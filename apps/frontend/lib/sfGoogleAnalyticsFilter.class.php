<?php

class sfGoogleAnalyticsFilter extends sfFilter
{
    public function execute($filterChain)
    {
        //var_dump("**sfGoogleAnalyticsFilter<br>");
        // Nothing to do before the action
        $filterChain->execute();

        // Decorate the response with the tracker code
        $googleCode = "<script type='text/javascript'>
          var _gaq = _gaq || [];
          _gaq.push(['_setAccount', 'UA-32153318-1']);
          _gaq.push(['_trackPageview']);

          (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
          })();
        </script>";
        $response = $this->getContext()->getResponse();
        $response->setContent(str_ireplace('</body>', $googleCode . '</body>', $response->getContent()));
    }
}