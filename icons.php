<?php
/**
 * icon() — cetak ikon garis (line icon) sebagai inline SVG.
 * Dipakai di seluruh halaman supaya tampilannya konsisten.
 */
function icon($name, $size = 18) {
    $paths = [
        'home'          => '<path d="M3 11.5 12 4l9 7.5"/><path d="M5.5 10v9.25c0 .41.34.75.75.75H10v-6h4v6h3.75c.41 0 .75-.34.75-.75V10"/>',
        'clipboard'     => '<rect x="5.5" y="4.5" width="13" height="16" rx="1.5"/><path d="M9 4.5V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v.5"/><path d="m8.5 12.5 2.3 2.3L15.5 10"/>',
        'users'         => '<circle cx="9" cy="8.5" r="3.25"/><path d="M3.5 20v-1.5A4.5 4.5 0 0 1 8 14h2a4.5 4.5 0 0 1 4.5 4.5V20"/><path d="M15.7 5.6a3.25 3.25 0 0 1 0 6.3"/><path d="M15.2 14.1c2 .3 3.8 1.8 3.8 3.9V20"/>',
        'cap'           => '<path d="M2.5 9.5 12 5l9.5 4.5L12 14 2.5 9.5Z"/><path d="M6.5 11.6V16c0 1.3 2.5 2.5 5.5 2.5s5.5-1.2 5.5-2.5v-4.4"/><path d="M21 10v5"/>',
        'bar-chart'     => '<path d="M5 20V10.5"/><path d="M12 20V4"/><path d="M19 20v-6.5"/><path d="M3.5 20.5h17"/>',
        'plus'          => '<path d="M12 5.5v13"/><path d="M5.5 12h13"/>',
        'pencil'        => '<path d="M14.7 4.3 19.7 9.3 8.2 20.8 3.5 21.5l.7-4.7Z"/><path d="M13 6l5 5"/>',
        'trash'         => '<path d="M4.5 7h15"/><path d="M9.5 7V5a1.5 1.5 0 0 1 1.5-1.5h2A1.5 1.5 0 0 1 14.5 5v2"/><path d="M6.5 7 7.3 19a2 2 0 0 0 2 1.9h5.4a2 2 0 0 0 2-1.9L17.5 7"/><path d="M10.3 11v6M13.7 11v6"/>',
        'x'             => '<path d="M6 6l12 12"/><path d="M18 6 6 18"/>',
        'filter'        => '<path d="M4 5h16"/><path d="M7.5 12h9"/><path d="M10.5 19h3"/>',
        'refresh'       => '<path d="M4.5 12a7.5 7.5 0 0 1 12.6-5.4M19.5 12a7.5 7.5 0 0 1-12.6 5.4"/><path d="M17 4.5v3h-3"/><path d="M7 19.5v-3h3"/>',
        'stamp'         => '<circle cx="12" cy="12" r="8.5"/><circle cx="12" cy="12" r="5.3"/><path d="m9.3 12.1 1.9 1.9 3.5-3.9"/>',
        'note'          => '<path d="M6 3.5h9l4.5 4.5V20a.7.7 0 0 1-.7.7H6a.7.7 0 0 1-.7-.7V4.2A.7.7 0 0 1 6 3.5Z"/><path d="M15 3.5V8h4.4"/><path d="M8.5 12.5h7M8.5 15.8h5"/>',
        'arrow-right'   => '<path d="M4.5 12h15"/><path d="m13.5 6 6 6-6 6"/>',
        'calendar'      => '<rect x="4" y="5.5" width="16" height="14.5" rx="1.5"/><path d="M8 3.5v4M16 3.5v4M4 10h16"/>',
    ];
    $body = $paths[$name] ?? '';
    return '<svg class="icn" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">' . $body . '</svg>';
}
?>