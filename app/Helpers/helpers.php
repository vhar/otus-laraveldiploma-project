<?php

if (! function_exists('\file_get_contents_ssl')) {
    function file_get_contents_ssl($path): bool|string
    {
        $ctx = stream_context_create([
            'ssl'  => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ]
        ]);

        return file_get_contents($path, 0, $ctx);
    }
}
