<?php

declare(strict_types=1);

namespace App\Outputs\Events;

use Illuminate\Support\Collection;

readonly class ClientJoinOutput implements EventOutput
{
    public function __construct(
        public int     $cfid,
        public int     $ctid,
        public int     $reason_id,
        public int     $client_id,
        public string  $client_unique_identifier,
        public string  $client_nickname,
        public bool    $client_input_muted,
        public bool    $client_output_muted,
        public bool    $client_output_only_muted,
        public bool    $client_input_hardware,
        public bool    $client_output_hardware,
        public ?string $client_meta_data = null,
        public bool    $client_is_recording,
        public int     $client_database_id,
        public int     $client_channel_group_id,
        public array   $client_servergroups,
        public bool    $client_away,
        public ?string $client_away_message = null,
        public int     $client_type,
        public bool    $client_flag_avatar,
        public int     $client_talk_power,
        public bool    $client_talk_request,
        public ?string $client_talk_request_msg = null,
        public ?string $client_description = null,
        public bool    $client_is_talker,
        public bool    $client_is_priority_speaker,
        public int     $client_unread_messages,
        public ?string $client_nickname_phonetic = null,
        public int     $client_needed_serverquery_view_power,
        public int     $client_icon_id,
        public bool    $client_is_channel_commander,
        public ?string $client_country = null,
        public ?string $client_channel_group_inherited_channel_id = null,
        public ?array  $client_badges = null,
        public ?string $client_myteamspeak_id = null,
        public ?array  $client_integrations = null,
        public ?string $client_myteamspeak_avatar = null,
        public ?array  $client_signed_badges = null,
    )
    {
    }

    public static function fromCollection(Collection $collection): self
    {
        return new self(
            cfid: (int)$collection->get('cfid'),
            ctid: (int)$collection->get('ctid'),
            reason_id: (int)$collection->get('reasonid'),
            client_id: (int)$collection->get('clid'),
            client_unique_identifier: $collection->get('client_unique_identifier'),
            client_nickname: $collection->get('client_nickname'),
            client_input_muted: (bool)$collection->get('client_input_muted'),
            client_output_muted: (bool)$collection->get('client_output_muted'),
            client_output_only_muted: (bool)$collection->get('client_output_only_muted'),
            client_input_hardware: (bool)$collection->get('client_input_hardware'),
            client_output_hardware: (bool)$collection->get('client_output_hardware'),
            client_meta_data: $collection->get('client_meta_data'),
            client_is_recording: (bool)$collection->get('client_is_recording'),
            client_database_id: (int)$collection->get('client_database_id'),
            client_channel_group_id: (int)$collection->get('client_channel_group_id'),
            client_servergroups: explode(',', (string)$collection->get('client_servergroups')),
            client_away: (bool)$collection->get('client_away'),
            client_away_message: $collection->get('client_away_message'),
            client_type: (int)$collection->get('client_type'),
            client_flag_avatar: (bool)$collection->get('client_flag_avatar'),
            client_talk_power: (int)$collection->get('client_talk_power'),
            client_talk_request: (bool)$collection->get('client_talk_request'),
            client_talk_request_msg: $collection->get('client_talk_request_msg'),
            client_description: $collection->get('client_description'),
            client_is_talker: (bool)$collection->get('client_is_talker'),
            client_is_priority_speaker: (bool)$collection->get('client_is_priority_speaker'),
            client_unread_messages: (int)$collection->get('client_unread_messages'),
            client_nickname_phonetic: $collection->get('client_nickname_phonetic'),
            client_needed_serverquery_view_power: (int)$collection->get('client_needed_serverquery_view_power'),
            client_icon_id: (int)$collection->get('client_icon_id'),
            client_is_channel_commander: (bool)$collection->get('client_is_channel_commander'),
            client_country: $collection->get('client_country'),
            client_channel_group_inherited_channel_id: $collection->get('client_channel_group_inherited_channel_id'),
            client_badges: $collection->get('client_badges'),
            client_myteamspeak_id: $collection->get('client_myteamspeak_id'),
            client_integrations: $collection->get('client_integrations'),
            client_myteamspeak_avatar: $collection->get('client_myteamspeak_avatar'),
            client_signed_badges: explode(',', (string)$collection->get('client_signed_badges')),
        );
    }
}
