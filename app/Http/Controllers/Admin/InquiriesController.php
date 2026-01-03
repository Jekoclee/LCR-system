<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InquiriesController extends Controller
{
    protected function detectIdColumn($con): ?string
    {
        $candidates = ['id', 'sr_no', 'srno', 'query_id', 'qid'];
        foreach ($candidates as $c) {
            $col = mysqli_real_escape_string($con, $c);
            $exists = @mysqli_query($con, "SHOW COLUMNS FROM `user_queries` LIKE '" . $col . "'");
            if ($exists && mysqli_num_rows($exists) > 0) {
                return $c;
            }
        }
        return null;
    }

    public function index(Request $request)
    {
        $items = [];
        $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
        if ($con) {
            $idCol = $this->detectIdColumn($con);
            $selectId = $idCol ? "`$idCol` AS id," : "";
            $q = "SELECT $selectId name, email, subject, message, `date`, seen FROM user_queries";
            $filters = [];
            if ($request->filled('q')) {
                $val = mysqli_real_escape_string($con, $request->input('q'));
                $filters[] = "(name LIKE '%$val%' OR email LIKE '%$val%' OR subject LIKE '%$val%' OR message LIKE '%$val%')";
            }
            if ($request->filled('seen')) {
                $seen = (int) $request->input('seen');
                $filters[] = "seen=$seen";
            }
            if ($filters) {
                $q .= " WHERE " . implode(' AND ', $filters);
            }
            $q .= " ORDER BY `date` DESC LIMIT 200";
            if ($res = mysqli_query($con, $q)) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $items[] = $row;
                }
            }
            mysqli_close($con);
        }
        return view('admin.inquiries.index', ['inquiries' => $items]);
    }

    public function show($id)
    {
        $inq = null;
        $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
        if ($con) {
            $idCol = $this->detectIdColumn($con) ?? 'id';
            $idVal = (int) $id;
            $q = "SELECT `$idCol` AS id, name, email, subject, message, `date`, seen FROM user_queries WHERE `$idCol`=$idVal LIMIT 1";
            if ($res = mysqli_query($con, $q)) {
                $inq = mysqli_fetch_assoc($res);
            }
            mysqli_close($con);
        }
        if (!$inq) {
            return redirect()->route('admin.inquiries.index')->with('error', 'Inquiry not found.');
        }
        return view('admin.inquiries.show', ['inq' => $inq]);
    }

    public function markSeen($id)
    {
        $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
        $ok = false;
        if ($con) {
            $idCol = $this->detectIdColumn($con) ?? 'id';
            $idVal = (int) $id;
            $ok = @mysqli_query($con, "UPDATE user_queries SET seen=1 WHERE `$idCol`=$idVal LIMIT 1");
            mysqli_close($con);
        }
        if ($ok) {
            return back()->with('success', 'Inquiry marked as seen.');
        }
        return back()->with('error', 'Failed to mark as seen.');
    }

    public function destroy($id)
    {
        $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
        $ok = false;
        if ($con) {
            $idCol = $this->detectIdColumn($con) ?? 'id';
            $idVal = (int) $id;
            $ok = @mysqli_query($con, "DELETE FROM user_queries WHERE `$idCol`=$idVal LIMIT 1");
            mysqli_close($con);
        }
        if ($ok) {
            return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted.');
        }
        return back()->with('error', 'Failed to delete inquiry.');
    }

    public function reply(Request $request, $id)
    {
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);
        $inq = null;
        $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
        if ($con) {
            $idCol = $this->detectIdColumn($con) ?? 'id';
            $idVal = (int) $id;
            $q = "SELECT `$idCol` AS id, name, email, subject, message, `date`, seen FROM user_queries WHERE `$idCol`=$idVal LIMIT 1";
            if ($res = mysqli_query($con, $q)) {
                $inq = mysqli_fetch_assoc($res);
            }
            // Mark as seen when replying
            @mysqli_query($con, "UPDATE user_queries SET seen=1 WHERE `$idCol`=$idVal LIMIT 1");
            mysqli_close($con);
        }
        if (!$inq || empty($inq['email'])) {
            return back()->with('error', 'Inquiry not found or missing email.');
        }
        try {
            \Illuminate\Support\Facades\Mail::to($inq['email'])->send(new \App\Mail\InquiryReplyMail($inq, $data['subject'], $data['message'], auth()->user()));
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to send reply email.');
        }
        return back()->with('success', 'Reply sent successfully.');
    }
}
