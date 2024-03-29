<?php

declare(strict_types=1);

namespace App\Outputs\Methods;

use App\Outputs\BaseOutput;
use Override;

class ServerInfo extends BaseOutput
{
    public function __construct(
        public int    $virtual_server_port,
        public string $virtual_server_name,
        public string $virtual_server_unique_identifier,
        public int    $max_clients,
        public int    $clients_online,
        public int    $error_id,
        public string $message,
    )
    {
    }

    #[Override]
    public static function createOutput(string $data): self
    {
        $output = collect(explode(' ', $data))
            ->mapWithKeys(static function ($item) {
                $split = explode('=', $item);
                return [$split[0] => $split[1] ?? null];
            });

        return new self(
            virtual_server_port: (int)$output->get('virtualserver_port'),
            virtual_server_name: $output->get('virtualserver_name') ?: '',
            virtual_server_unique_identifier: $output->get('virtualserver_unique_identifier') ?: '',
            max_clients: (int)$output->get('virtualserver_maxclients'),
            clients_online: (int)$output->get('virtualserver_clientsonline'),
            error_id: (int)$output->get('id'),
            message: $output->get('msg') ?: '',
        );
    }
}
