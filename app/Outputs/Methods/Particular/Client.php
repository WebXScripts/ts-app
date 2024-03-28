<?php

declare(strict_types=1);

namespace App\Outputs\Methods\Particular;

use Illuminate\Support\Collection;

readonly class Client
{
    public function __construct(
        public ?int        $client_id = null,
        public ?int        $channel_id = null,
        public ?int        $database_id = null,
        public ?string     $nickname = null,
        public ?string     $description = null,
        public ?int        $client_type = null,
        public ?bool       $away = null,
        public ?string     $away_message = null,
        public ?bool       $flag_talking = null,
        public ?bool       $input_muted = null,
        public ?bool       $output_muted = null,
        public ?bool       $input_hardware = null,
        public ?bool       $output_hardware = null,
        public ?int        $talk_power = null,
        public ?bool       $is_talker = null,
        public ?bool       $is_priority_speaker = null,
        public ?bool       $is_recording = null,
        public ?bool       $is_channel_commander = null,
        public ?string     $unique_identifier = null,
        public ?Collection $servergroups = null,
        public ?int        $channel_group_id = null,
        public ?int        $channel_group_inherited_channel_id = null,
        public ?string     $version = null,
        public ?string     $platform = null,
        public ?int        $idle_time = null,
        public ?int        $created = null,
        public ?int        $last_connected = null,
        public ?int        $icon_id = null,
        public ?string     $country = null,
        public ?string     $connection_client_ip = null,
        public ?string     $badges = null,
    )
    {
    }
}
