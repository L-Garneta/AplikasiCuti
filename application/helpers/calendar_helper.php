<?php
//Membuat Fungsi PHP
//Draw Calendar
function draw_calendar($month, $year)
{
    // Draw table for Calendar 
    $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
    // Draw Calendar table headings 
    $headings = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
    $calendar .= '<tr class="calendar-row"><td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';
    //days and weeks variable for now ... 
    $running_day = date('w', mktime(0, 0, 0, $month, 2, $year));
    $days_in_month = date('t', mktime(0, 0, 0, $month, 2, $year));
    $days_in_this_week = 1;
    $day_counter = 0;
    $dates_array = array();
    // row for week one 
    $calendar .= '<tr class="calendar-row">';
    // Display "blank" days until the first of the current week 
    for ($x = 0; $x < $running_day; $x++) :
        $calendar .= '<td class="calendar-day-np">&nbsp;</td>';
        $days_in_this_week++;
    endfor;
    // Show days.... 
    for ($list_day = 1; $list_day <= $days_in_month; $list_day++) :
        if ($list_day == date('d') && $month == date('n')) {
            $currentday = 'currentday';
        } else {
            $currentday = '';
        }
        $calendar .= '<td class="calendar-day ' . $currentday . '">';

        // Add in the day number
        if ($list_day < date('d') && $month == date('n')) {
            $showtoday = '<strong class="overday">' . $list_day . '</strong>';
        } else {
            $showtoday = $list_day;
        }
        $calendar .= '<div class="day-number">' . $showtoday . '</div>';
        // Draw table end
        $calendar .= '</td>';
        if ($running_day == 6) :
            $calendar .= '</tr>';
            if (($day_counter + 1) != $days_in_month) :
                $calendar .= '<tr class="calendar-row">';
            endif;
            $running_day = -1;
            $days_in_this_week = 0;
        endif;
        $days_in_this_week++;
        $running_day++;
        $day_counter++;
    endfor;
    // Finish the rest of the days in the week
    if ($days_in_this_week < 8) :
        for ($x = 1; $x <= (8 - $days_in_this_week); $x++) :
            $calendar .= '<td class="calendar-day-np">&nbsp;</td>';
        endfor;
    endif;
    // Draw table final row
    $calendar .= '</tr>';
    // Draw table end the table 
    $calendar .= '</table>';

    // Finally all done, return result 
    return $calendar;
}
