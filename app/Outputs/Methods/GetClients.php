<?php

declare(strict_types=1);

namespace App\Outputs\Methods;

use App\Outputs\BaseOutput;
use App\Outputs\Methods\Particular\Client;
use App\Utils\Actions\BoolNull;
use Illuminate\Support\Collection;
use Override;

class GetClients extends BaseOutput
{
    public function __construct(
        /** @var Collection<Client> $clients */
        private readonly Collection $clients
    )
    {
    }

    /**
     * @param string $data
     * @return GetClients
     */
    #[Override]
    public static function createOutput(string $data): self
    {
        return new self(
            clients: collect(explode(
                '|',
                preg_replace('/error id=\d+ msg=\w+/', '', $data)
            ))->map(static function (string $clientData) {
                return collect(explode(' ', $clientData))
                    ->mapWithKeys(static function ($item) {
                        $split = explode('=', $item);
                        return [$split[0] => $split[1] ?? null];
                    });
            })->map(static function ($client) {
                return new Client(
                    client_id: (int)$client->get('clid'),
                    channel_id: (int)$client->get('cid'),
                    database_id: (int)$client->get('client_database_id'),
                    nickname: $client->get('client_nickname'),
                    client_type: (int)$client->get('client_type'),
                    description: $client->get('client_description'),
                    away: BoolNull::handle(
                        field: $client->get('client_away'),
                    ),
                    away_message: $client->get('client_away_message'),
                    flag_talking: $client->get('client_flag_talking'),
                    input_muted: BoolNull::handle(
                        field: $client->get('client_input_muted'),
                    ),
                    output_muted: BoolNull::handle(
                        field: $client->get('client_output_muted'),
                    ),
                    input_hardware: BoolNull::handle(
                        field: $client->get('client_input_hardware'),
                    ),
                    output_hardware: BoolNull::handle(
                        field: $client->get('client_output_hardware'),
                    ),
                    talk_power: (int)$client->get('client_talk_power'),
                    is_talker: BoolNull::handle(
                        field: $client->get('client_is_talker'),
                    ),
                    is_priority_speaker: BoolNull::handle(
                        field: $client->get('client_is_priority_speaker'),
                    ),
                    is_recording: BoolNull::handle(
                        field: $client->get('client_is_recording'),
                    ),
                    is_channel_commander: BoolNull::handle(
                        field: $client->get('client_is_channel_commander'),
                    ),
                    unique_identifier: $client->get('client_unique_identifier'),
                    groups: collect(explode(',', (string)$client->get('client_servergroups')))
                        ->map(static function (string $group) {
                            return (int)$group;
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
                    connection_client_ip: $client->get('connection_client_ip'),
                    badges: $client->get('client_badges')
                );
            })
        );
    }

    public function list(): Collection
    {
        return $this->clients;
    }
}
