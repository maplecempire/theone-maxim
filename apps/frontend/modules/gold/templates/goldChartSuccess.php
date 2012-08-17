<?php use_helper('I18N') ?>
<script type='text/javascript' src='/js/deployJava.js'></script>


<script type="text/javascript">
    try
    {
        var attributes = {
            name: 'chartApplet',
            codebase: 'http://www.galmarley.com/ChartApp/',
            archive: 'ChartApp.jar?t=20110421013926',
            code: 'com.bullionvault.chart.run.ChartApp.class',
            mayscript: true,
            height: '300', width: '400'
        } ;
        var parameters = {
            locale: 'en',
            displayMode: 'BullionVault',
            currency: 'menu.currency.USD" />',

            goRealtime: true,
            Series: 'menu.series.spotgold'
        } ;
        deployJava.writeAppletTag( attributes, parameters, 1.4 );
    }
    catch(ex)
    {

    }
</script>