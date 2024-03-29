<?php

declare(strict_types=1);

namespace App\Outputs\Methods;

use App\Outputs\BaseOutput;
use App\Outputs\Methods\Particular\Client;
use Illuminate\Support\Collection;
use Override;

class GetClients extends BaseOutput
{
    public function __construct(
        public int          $error_id,
        public string       $message,

        /** @var ?Collection<Client> $clients */
        private ?Collection $clients = null,
    )
    {
    }

    /**
     * @param string $data
     * @return BaseOutput
     * @todo Horrible code, but it works for now.
     */
    #[Override]
    public static function createOutput(string $data): BaseOutput
    {
        $error = collect(explode(' ', $data))
            ->mapWithKeys(static function ($item) {
                $split = explode('=', $item);
                return [$split[0] => $split[1] ?? null];
            });

        if ($error->get('id') !== '0') {
            return new self(
                error_id: (int)$error->get('id'),
                message: $error->get('msg') ?: ''
            );
        }

        $clients = collect(explode('|', $data))
            ->map(static function ($client) {
                return collect(explode(' ', $client))
                    ->mapWithKeys(static function ($item) {
                        $split = explode('=', $item);
                        return [$split[0] => $split[1] ?? null];
                    });
            })
            ->map(static function ($client) {
                return new Client(
                    client_id: (int)$client->get('clid'),
                    channel_id: (int)$client->get('cid'),
                    database_id: (int)$client->get('client_database_id'),
                    nickname: $client->get('client_nickname'),
                    client_type: (int)$client->get('client_type'),
                    description: $client->get('client_description'),
                    away: (bool)$client->get('client_away'),
                    away_message: $client->get('client_away_message'),
                    flag_talking: (bool)$client->get('client_flag_talking'),
                    input_muted: (bool)$client->get('client_input_muted'),
                    output_muted: (bool)$client->get('client_output_muted'),
                    input_hardware: (bool)$client->get('client_input_hardware'),
                    output_hardware: (bool)$client->get('client_output_hardware'),
                    talk_power: (int)$client->get('client_talk_power'),
                    is_talker: (bool)$client->get('client_is_talker'),
                    is_priority_speaker: (bool)$client->get('client_is_priority_speaker'),
                    is_recording: (bool)$client->get('client_is_recording'),
                    is_channel_commander: (bool)$client->get('client_is_channel_commander'),
                    unique_identifier: $client->get('client_unique_identifier'),
                    servergroups: collect(explode(',', (string)$client->get('client_servergroups')))->map(static function ($servergroup) {
                        return (int)$servergroup;
                    }),
                    channel_group_id: (int)$client->get('client_channel_group_id'),
                    channel_group_inherited_channel_id: (int)$client->get('client_channel_group_inherited_channel_id'),
                    version: $client->get('client_version'),
                    platform: $client->get('client_platform'),
                    idle_time: (int)$client->get('client_idle_time'),
                    created: (int)$client->get('client_created'),
                    last_connected: (int)$client->get('client_lastconnected'),
                    icon_id: (int)$client->get('client_icon_id'),
                    country: $client->get('client_country'),
                    connection_client_ip: $client->get('connection_client_ip')
                        ? str_replace('error', '', $client->get('connection_client_ip'))
                        : null,
                    badges: $client->get('client_badges')
                );
            });

        return new self(
            error_id: (int)$error->get('id'),
            message: $error->get('msg') ?: '',
            clients: $clients
        );
    }

    public function list(): Collection
    {
        if ($this->clients === null) {
            return collect();
        }

        return $this->clients;
    }
}
