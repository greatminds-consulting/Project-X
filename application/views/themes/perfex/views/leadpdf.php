<?php

$dimensions = $pdf->getPageDimensions();

$info_right_column = '';
$info_left_column = '';

$info_right_column .= '<span style="font-weight:bold;font-size:27px;">'._l('leads_pdf_heading').'</span><br />';
$info_right_column .= '<b style="color:#4e4e4e;">#'.$estimate->id.' </b>';

if(get_option('show_status_on_pdf_ei') == 1){
    $info_right_column .= '<br /><span style="color:rgb('.estimate_status_color_pdf(1).');text-transform:uppercase;">' . format_estimate_status(1,'',false) . '</span>';
}

// write the first column
$info_left_column .= pdf_logo_url();
$pdf->MultiCell(($dimensions['wk'] / 2) - $dimensions['lm'], 0, $info_left_column, 0, 'J', 0, 0, '', '', true, 0, true, true, 0);
// write the second column
$pdf->MultiCell(($dimensions['wk'] / 2) - $dimensions['rm'], 0, $info_right_column, 0, 'R', 0, 1, '', '', true, 0, true, false, 0);
$pdf->ln(10);

// Get Y position for the separation
$y            = $pdf->getY();
$organization_info = '<div style="color:#424242;">';
    $organization_info .= format_organization_info();
$organization_info .= '</div>';

$pdf->writeHTMLCell(($swap == '1' ? ($dimensions['wk']) - ($dimensions['lm'] * 2) : ($dimensions['wk'] / 2) - $dimensions['lm']), '', '', $y, $organization_info, 0, 0, false, true, ($swap == '1' ? 'R' : 'J'), true);

// Estimate to
$estimate_info = '<b></b>';
$estimate_info .= '<div style="color:#424242;">';
$estimate_info .= format_customer_info($estimate, 'estimate', 'billing');
$estimate_info .= '</div>';

// ship to to
if($estimate->include_shipping == 1 && $estimate->show_shipping_on_estimate == 1){
    $estimate_info .= '<br /><b></b>';
    $estimate_info .= '<div style="color:#424242;">';
    $estimate_info .= format_customer_info($estimate, 'estimate', 'shipping');
    $estimate_info .= '</div>';
}

$estimate_info .= '<br /><br />';

if (!empty($estimate->name)) {
    $estimate_info .= _l('leads_dt_name') . ': ' . $estimate->name . '<br />';
}

if (!empty($estimate->email)) {
    $estimate_info .= _l('leads_dt_email') . ': ' . $estimate->email. '<br />';
}
if (!empty($estimate->description)) {
    $estimate_info .= _l('leads_dt_description') . ': ' . $estimate->description. '<br />';
}
if (!empty($estimate->state)) {
    $estimate_info .= _l('leads_dt_state') . ': ' . $estimate->state. '<br />';
}
if (!empty($estimate->city)) {
    $estimate_info .= _l('leads_dt_city') . ': ' . $estimate->city. '<br />';
}if (!empty($estimate->company)) {
    $estimate_info .= _l('leads_dt_company') . ': ' . $estimate->company. '<br />';
}


foreach($pdf_custom_fields as $field){
    $value = get_custom_field_value($estimate->id,$field['id'],'estimate');
    if($value == ''){continue;}
    $estimate_info .= $field['name'] . ': ' . $value. '<br />';
}

$pdf->writeHTMLCell(($dimensions['wk'] / 2) - $dimensions['rm'], '', '', ($swap == '1' ? $y : ''), $estimate_info, 0, 1, false, true, ($swap == '1' ? 'J' : 'R'), true);

// The Table
$pdf->Ln(6);
$item_width = 38;
// If show item taxes is disabled in PDF we should increase the item width table heading
$item_width = get_option('show_tax_per_item') == 0 ? $item_width+15 : $item_width;
$custom_fields_items = get_items_custom_fields_for_table_html($estimate->id,'estimate');

// Calculate headings width, in case there are custom fields for items
$total_headings = get_option('show_tax_per_item') == 1 ? 4 : 3;
$total_headings += count($custom_fields_items);
$headings_width = (100-($item_width+6)) / $total_headings;


// Header
$tblhtml = '<table width="100%" bgcolor="#fff" cellspacing="0" cellpadding="8">';
$tblhtml .= '<tr height="30" bgcolor="' . get_option('pdf_table_heading_color') . '" style="color:' . get_option('pdf_table_heading_text_color') . ';">';
$tblhtml .= '<th>#</th>';
$tblhtml .= '<th>' . _l('proposal') . '</th>';
$tblhtml .= '<th>' . _l('proposal_total') .  '</th>';
$tblhtml .= '<th>' . _l('proposal_date_created') . '</th>';
$tblhtml .= '<th>' . _l('proposal_date') . '</th>';
$tblhtml .= '<th>' . _l('proposal_open_till') . '</th>';
$tblhtml .= '<th>' . _l('proposal_status') . '</th>';
$tblhtml .= '</tr>';
$tblhtml .= '<tbody>';
foreach ($proposals as $proposal) {
    $tblhtml .= '<tr>';
    $tblhtml .= '<td>' . $proposal["id"] .  '</td>';
    $tblhtml .= '<td>' . $proposal["subject"] .  '</td>';
    $tblhtml .= '<td>' . $proposal["total"] .  '</td>';
    $tblhtml .= '<td>' . _d($proposal["datecreated"]) .  '</td>';
    $tblhtml .= '<td>' . _d($proposal["date"]) .  '</td>';
    $tblhtml .= '<td>' . _d($proposal["open_till"]) .  '</td>';
    $tblhtml .= '<td>' . format_proposal_status($proposal["status"]) .  '</td>';
    $tblhtml .= '</tr>';
}
$tblhtml .= '</tbody>';
$tblhtml .= '</table>';
$pdf->writeHTML($tblhtml, true, false, false, false, '');

if(get_option('total_to_words_enabled') == 1){
    // Set the font bold
    $pdf->SetFont($font_name,'B',$font_size);
    $pdf->Cell(0, 0, _l('num_word').': '.$CI->numberword->convert($estimate->total,$estimate->currency_name), 0, 1, 'C', 0, '', 0);
    // Set the font again to normal like the rest of the pdf
    $pdf->SetFont($font_name,'',$font_size);
    $pdf->Ln(4);
}

if (!empty($estimate->clientnote)) {
    $pdf->Ln(4);
    $pdf->SetFont($font_name,'B',$font_size);
    $pdf->Cell(0, 0, _l('estimate_note'), 0, 1, 'L', 0, '', 0);
    $pdf->SetFont($font_name,'',$font_size);
    $pdf->Ln(2);
    $pdf->writeHTMLCell('', '', '', '', $estimate->clientnote, 0, 1, false, true, 'L', true);
}

if (!empty($estimate->terms)) {
    $pdf->Ln(4);
    $pdf->SetFont($font_name,'B',$font_size);
    $pdf->Cell(0, 0, _l('terms_and_conditions'), 0, 1, 'L', 0, '', 0);
    $pdf->SetFont($font_name,'',$font_size);
    $pdf->Ln(2);
    $pdf->writeHTMLCell('', '', '', '', $estimate->terms, 0, 1, false, true, 'L', true);
}
