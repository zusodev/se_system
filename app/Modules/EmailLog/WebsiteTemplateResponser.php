<?php


namespace App\Modules\EmailLog;


class WebsiteTemplateResponser
{
    public static function setTemplateFormUrlScript(string $template, string $route)
    {

        $jqueryUrl = asset('js/jquery.min.js');
        $template .= <<<EOL
<script src="{$jqueryUrl}"></script>
EOL;
        if (env('SEND_MAIL_CLEAR_INPUT', false)) {
            $template .= <<<EOL
<script>
    setTimeout(function (){
        $('form').prop('action', "$route");
        $('form').attr('method', 'post');

        $( "form" ).submit(function( event ) {
            $('input').val('');
        });

    }, 1000);
</script>
EOL;
        } else {
            $template .= <<<EOL
<script>
    setTimeout(function (){
        $('form').prop('action', "$route");
        $('form').attr('method', 'post');
    }, 1000);
</script>
EOL;
        }

        return $template;
    }
}
