<?php

    include($_SERVER['DOCUMENT_ROOT'].'/projects/event-registration/wp-load.php');
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'event_registrants';
    $event_table = $wpdb->prefix . 'event';
    
    //$eventID = 1;
    $eventID = $_GET['event_id'];
    //echo $eventID;
    $event_registrants = $wpdb->get_results("SELECT * FROM ".$table_name." WHERE event_id = $eventID ORDER BY id ASC");
    
    $data = '';
    
    header('Content-type: application/excel');
    $filename = 'event-registration.xls';
    header('Content-Disposition: attachment; filename='.$filename);
    
    $data .= '<html xmlns:x="urn:schemas-microsoft-com:office:excel">
    <head>
        <!--[if gte mso 9]>
        <xml>
            <x:ExcelWorkbook>
                <x:ExcelWorksheets>
                    <x:ExcelWorksheet>
                        <x:Name>Sheet 1</x:Name>
                        <x:WorksheetOptions>
                            <x:Print>
                                <x:ValidPrinterInfo/>
                            </x:Print>
                        </x:WorksheetOptions>
                    </x:ExcelWorksheet>
                </x:ExcelWorksheets>
            </x:ExcelWorkbook>
        </xml>
        <![endif]-->
    </head>
    <body>';
       $data .= '<table>
            <tr>
                <td>Event</td><td>First Name</td><td>Last Name</td><td>Email</td><td>Phone no</td>
                <td>Address</td><td>City</td><td>State/Province</td><td>Country</td>
            </tr>';
            
            foreach($event_registrants as $event_registrant){
                $event = $wpdb->get_results("SELECT title FROM ".$event_table." WHERE id = $event_registrant->event_id");
                $data .= '<tr>';
                    $data .= '<td>'.$event[0]->title.'</td>';
                    $data .= '<td>'.$event_registrant->first_name.'</td>';
                    $data .= '<td>'.$event_registrant->last_name.'</td>';
                    $data .= '<td>'.$event_registrant->email.'</td>';
                    $data .= '<td>'.$event_registrant->phone_no.'</td>';
                    $data .= '<td>'.$event_registrant->address.'</td>';
                    $data .= '<td>'.$event_registrant->city.'</td>';
                    $data .= '<td>'.$event_registrant->state_province.'</td>';
                    $data .= '<td>'.$event_registrant->country.'</td>';
                $data .= '</tr>';
            }

    $data .= '</table>
    </body></html>';
    
    
    echo $data;