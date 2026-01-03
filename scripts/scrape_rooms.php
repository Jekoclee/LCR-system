<?php
$checkin = $_GET['checkin'] ?? '2026-01-02';
$checkout = $_GET['checkout'] ?? '2026-01-04';
$url = "http://localhost/LCR%20WEBSITE/select_rooms_rates.php?checkin={$checkin}&checkout={$checkout}";
$html = @file_get_contents($url);
if ($html === false) {
    echo json_encode(['error' => 'Unable to fetch URL'], JSON_UNESCAPED_UNICODE);
    exit;
}
$rooms = [];
$attrPattern = "/<div class='room-card h-100' data-room-id='(\\d+)' data-room-price='(\\d+)' data-room-adult='(\\d+)' data-room-children='(\\d+)'/";
$namePattern = "/<h6 class='room-title'>([^<]+)<\\/h6>/";
$areaPattern = "/<span><i class='bi bi-house-door-fill'><\\/i> (\\d+) m/";
$thumbPattern = "/<div class='room-image'>\\s*<img src='([^']+)'/";
preg_match_all($attrPattern, $html, $ma);
preg_match_all($namePattern, $html, $mn);
preg_match_all($areaPattern, $html, $ar);
preg_match_all($thumbPattern, $html, $th);
$count = min(count($ma[1] ?? []), count($mn[1] ?? []));
for ($i = 0; $i < $count; $i++) {
    $rooms[] = [
        'id' => (int) $ma[1][$i],
        'name' => $mn[1][$i],
        'price' => (int) $ma[2][$i],
        'adults' => (int) $ma[3][$i],
        'children' => (int) $ma[4][$i],
        'area' => isset($ar[1][$i]) ? (int) $ar[1][$i] : null,
        'thumb' => isset($th[1][$i]) ? $th[1][$i] : '',
    ];
}
echo json_encode($rooms, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
