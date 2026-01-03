<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    protected function columnExists($con, string $table, string $col): bool
    {
        $exists = @mysqli_query($con, "SHOW COLUMNS FROM `" . mysqli_real_escape_string($con, $table) . "` LIKE '" . mysqli_real_escape_string($con, $col) . "'");
        return $exists && mysqli_num_rows($exists) > 0;
    }

    protected function detectUnitsColumn($con): ?string
    {
        foreach (['units', 'room_units', 'room_unit', 'quantity', 'qty', 'stock'] as $c) {
            $exists = @mysqli_query($con, "SHOW COLUMNS FROM `rooms` LIKE '" . mysqli_real_escape_string($con, $c) . "'");
            if ($exists && mysqli_num_rows($exists) > 0) {
                return $c;
            }
        }
        return null;
    }

    public function index()
    {
        $rooms = [];
        $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
        if ($con) {
            $unitsCol = $this->detectUnitsColumn($con);
            $hasPrice = $this->columnExists($con, 'rooms', 'price');
            $hasRemoved = $this->columnExists($con, 'rooms', 'removed');
            $hasStatus = $this->columnExists($con, 'rooms', 'status');
            $selects = ['id', 'name'];
            if ($hasPrice) {
                $selects[] = 'price';
            }
            if ($unitsCol) {
                $selects[] = "`" . $unitsCol . "` AS units_val";
            }
            $whereParts = [];
            if ($hasRemoved) {
                $whereParts[] = "removed=0";
            }
            if ($hasStatus) {
                $whereParts[] = "status=1";
            }
            $sql = "SELECT " . implode(', ', $selects) . " FROM rooms";
            if (!empty($whereParts)) {
                $sql .= " WHERE " . implode(' AND ', $whereParts);
            }
            $sql .= " ORDER BY name ASC";
            if ($res = @mysqli_query($con, $sql)) {
                while ($row = mysqli_fetch_assoc($res)) {
                    $rooms[] = [
                        'id' => (int) $row['id'],
                        'name' => $row['name'],
                        'price' => $hasPrice ? (isset($row['price']) ? (int) $row['price'] : null) : null,
                        'units' => $unitsCol ? (int) ($row['units_val'] ?? 0) : null,
                    ];
                }
            }
            mysqli_close($con);
        }
        return view('admin.rooms.index', ['rooms' => $rooms]);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'units' => ['required', 'integer', 'min:0'],
        ]);

        $units = (int) $data['units'];

        $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
        if (!$con) {
            return back()->with('error', 'Hindi makakonekta sa LCR WEBSITE database.');
        }

        $unitsCol = null;
        $colCandidates = ['units', 'room_units', 'room_unit', 'quantity', 'qty', 'stock'];
        foreach ($colCandidates as $c) {
            $exists = @mysqli_query($con, "SHOW COLUMNS FROM `rooms` LIKE '" . mysqli_real_escape_string($con, $c) . "'");
            if ($exists && mysqli_num_rows($exists) > 0) {
                $unitsCol = $c;
                break;
            }
        }
        if (!$unitsCol) {
            mysqli_close($con);
            return back()->with('error', 'Walang units column sa database.');
        }

        $sql = "UPDATE `rooms` SET `" . $unitsCol . "`=" . $units . " WHERE `id`=" . (int) $id . " LIMIT 1";
        $ok = @mysqli_query($con, $sql);
        $affected = $ok ? mysqli_affected_rows($con) : 0;
        mysqli_close($con);

        if ($ok && $affected >= 0) {
            return back()->with('success', 'Room updated successfully!');
        }

        return back()->with('error', 'Update failed. Paki-try ulit.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'integer', 'min:0'],
            'units' => ['required', 'integer', 'min:0'],
        ]);
        $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
        if (!$con) {
            return back()->with('error', 'Hindi makakonekta sa LCR WEBSITE database.');
        }
        $cols = [];
        $vals = [];
        $cols[] = 'name';
        $vals[] = "'" . mysqli_real_escape_string($con, $data['name']) . "'";
        if ($this->columnExists($con, 'rooms', 'description')) {
            $cols[] = 'description';
            $vals[] = "'" . mysqli_real_escape_string($con, $data['description'] ?? '') . "'";
        }
        if ($this->columnExists($con, 'rooms', 'price')) {
            $cols[] = 'price';
            $vals[] = (string) ((int) ($data['price'] ?? 0));
        }
        $unitsCol = $this->detectUnitsColumn($con);
        if ($unitsCol) {
            $cols[] = $unitsCol;
            $vals[] = (string) ((int) $data['units']);
        }
        if ($this->columnExists($con, 'rooms', 'status')) {
            $cols[] = 'status';
            $vals[] = '1';
        }
        if ($this->columnExists($con, 'rooms', 'removed')) {
            $cols[] = 'removed';
            $vals[] = '0';
        }
        if (empty($unitsCol)) {
            mysqli_close($con);
            return back()->with('error', 'Walang units column sa database.');
        }
        $sql = "INSERT INTO `rooms` (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $vals) . ")";
        $ok = @mysqli_query($con, $sql);
        mysqli_close($con);
        if ($ok) {
            return back()->with('success', 'Room created successfully!');
        }
        return back()->with('error', 'Failed to create room.');
    }

    public function updateFull(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'units' => ['required', 'integer', 'min:0'],
        ]);
        $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
        if (!$con) {
            return back()->with('error', 'Hindi makakonekta sa LCR WEBSITE database.');
        }
        $name = mysqli_real_escape_string($con, $data['name']);
        $unitsCol = null;
        $colCandidates = ['units', 'room_units', 'room_unit', 'quantity', 'qty', 'stock'];
        foreach ($colCandidates as $c) {
            $exists = @mysqli_query($con, "SHOW COLUMNS FROM `rooms` LIKE '" . mysqli_real_escape_string($con, $c) . "'");
            if ($exists && mysqli_num_rows($exists) > 0) {
                $unitsCol = $c;
                break;
            }
        }
        if (!$unitsCol) {
            mysqli_close($con);
            return back()->with('error', 'Walang units column sa database.');
        }
        $sql = "UPDATE `rooms` SET `name`='{$name}', `{$unitsCol}`=" . (int) $data['units'] . " WHERE `id`=" . (int) $id . " LIMIT 1";
        $ok = @mysqli_query($con, $sql);
        mysqli_close($con);
        if ($ok) {
            return back()->with('success', 'Room updated successfully!');
        }
        return back()->with('error', 'Failed to update room.');
    }

    public function destroy(int $id)
    {
        $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
        if (!$con) {
            return back()->with('error', 'Hindi makakonekta sa LCR WEBSITE database.');
        }
        $sql = null;
        if ($this->columnExists($con, 'rooms', 'removed')) {
            $sql = "UPDATE `rooms` SET `removed`=1 WHERE `id`=" . (int) $id . " LIMIT 1";
        } elseif ($this->columnExists($con, 'rooms', 'status')) {
            $sql = "UPDATE `rooms` SET `status`=0 WHERE `id`=" . (int) $id . " LIMIT 1";
        } else {
            $sql = "DELETE FROM `rooms` WHERE `id`=" . (int) $id . " LIMIT 1";
        }
        $ok = @mysqli_query($con, $sql);
        mysqli_close($con);
        if ($ok) {
            return back()->with('success', 'Room deleted successfully!');
        }
        return back()->with('error', 'Failed to delete room.');
    }
}
