/**
 *
 * Created by blond.
 * File: SuiviStat.js
 * Date: 24/05/15 - 21:23
 *
 */

function getDataTableStat()
{
    $.getJSON(
        'SuiviStat',
        {
            'action': 'getDataTableStat',
            'async': '1',
            'async_data': '1'
        },
        function (data)
        {
            //console.log(data);
        }
    );
}

function getDataForTableStat() {
    $.getJSON(
        'SuiviStat',
        {
            'action': 'getDataTableStat',
            'async': '1',
            'DateBegin': $('#searchDateDossierBegin').val(),
            'DateEnd': $('#searchDateDossierEnd').val()
        },
        function (data) {
//                    console.log(data);
            $('#tableStat').html(data.SentData);
        }
    );
}