<?php

declare(strict_types=1);

namespace App\Outputs\Methods;

use App\Outputs\BaseOutput;
use App\Traits\IsOutput;

class ServerInfo implements BaseOutput
{
    use IsOutput;

    public function __construct(
        public ?int    $virtual_server_port = null,
        public ?string $virtual_server_name = null,
        public ?string $virtual_server_unique_identifier = null,
        public ?int    $max_clients = null,
        public ?int    $clients_online = null,
        public ?int    $error_id = null,
        public ?string $message = null,
    )
    {
    }

    public static function createOutput(array $data): self
    {
        $output = collect($data)->mapWithKeys(static function ($item) {
            $split = explode('=', $item);
            return [$split[0] => $split[1] ?? null];
        });

        return new self(
            virtual_server_port: (int)$output->get('virtualserver_port'),
            virtual_server_name: $output->get('virtualserver_name'),
            virtual_server_unique_identifier: $output->get('virtualserver_unique_identifier'),
            max_clients: (int)$output->get('virtualserver_maxclients'),
            clients_online: (int)$output->get('virtualserver_clientsonline'),
            error_id: (int)$output->get('id'),
            message: $output->get('msg')
        );
    }
}
