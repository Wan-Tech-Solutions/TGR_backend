<?php

namespace App\Services;

use Carbon\Carbon;

class IcsGenerator
{
    /**
     * Generate an .ics calendar file content
     *
     * @param \App\Models\Event $event
     * @return string
     */
    public static function generate($event)
    {
        $startDateTime = Carbon::parse($event->event_date . ' ' . $event->event_time);
        $endDateTime = clone $startDateTime;
        $endDateTime->addHour(); // Default 1 hour duration

        $now = Carbon::now();

        // Format dates for ICS (YYYYMMDDTHHmmss)
        $dtstart = $startDateTime->format('Ymd\THis');
        $dtend = $endDateTime->format('Ymd\THis');
        $dtstamp = $now->format('Ymd\THis');

        // Generate unique ID
        $uid = md5($event->id . $event->event_title . $event->event_date);

        // Escape special characters for ICS format
        $summary = self::escapeString($event->event_title);
        $description = self::escapeString($event->description ?? 'Event notification from TGR Africa');
        $location = self::escapeString($event->location ?? 'TBA');

        // Build ICS content
        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//TGR Africa//Event Calendar//EN\r\n";
        $ics .= "CALSCALE:GREGORIAN\r\n";
        $ics .= "METHOD:REQUEST\r\n";
        $ics .= "BEGIN:VEVENT\r\n";
        $ics .= "UID:" . $uid . "@tgr-africa.com\r\n";
        $ics .= "DTSTAMP:" . $dtstamp . "\r\n";
        $ics .= "DTSTART:" . $dtstart . "\r\n";
        $ics .= "DTEND:" . $dtend . "\r\n";
        $ics .= "SUMMARY:" . $summary . "\r\n";
        $ics .= "DESCRIPTION:" . $description . "\r\n";
        $ics .= "LOCATION:" . $location . "\r\n";
        $ics .= "STATUS:CONFIRMED\r\n";
        $ics .= "SEQUENCE:0\r\n";
        $ics .= "PRIORITY:" . self::getPriority($event->priority) . "\r\n";

        // Add organizer
        $ics .= "ORGANIZER;CN=TGR Africa:mailto:noreply@tgrafrica.com\r\n";

        // Add alarm/reminder (15 minutes before)
        $ics .= "BEGIN:VALARM\r\n";
        $ics .= "TRIGGER:-PT15M\r\n";
        $ics .= "ACTION:DISPLAY\r\n";
        $ics .= "DESCRIPTION:Event Reminder\r\n";
        $ics .= "END:VALARM\r\n";

        $ics .= "END:VEVENT\r\n";
        $ics .= "END:VCALENDAR\r\n";

        return $ics;
    }

    /**
     * Escape string for ICS format
     *
     * @param string $string
     * @return string
     */
    private static function escapeString($string)
    {
        $string = str_replace("\\", "\\\\", $string);
        $string = str_replace(",", "\\,", $string);
        $string = str_replace(";", "\\;", $string);
        $string = str_replace("\n", "\\n", $string);
        $string = str_replace("\r", "", $string);

        return $string;
    }

    /**
     * Convert priority to ICS format
     *
     * @param string $priority
     * @return int
     */
    private static function getPriority($priority)
    {
        switch ($priority) {
            case 'high':
                return 1;
            case 'medium':
                return 5;
            case 'low':
                return 9;
            default:
                return 5;
        }
    }
}
