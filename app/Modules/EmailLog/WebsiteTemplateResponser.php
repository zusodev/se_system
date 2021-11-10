<?php


namespace App\Modules\EmailLog;


use Illuminate\Http\Response;

class WebsiteTemplateResponser
{
    public static function setTemplateFormUrlScript(string $template, string $route)
    {

        $jqueryUrl = asset('js/jquery.min.js');
        $template .= <<<EOL
<script src="{$jqueryUrl}"></script>
EOL;

        $template .= <<<EOL
<script>
    setTimeout(function (){
        $('form').prop('action', "$route");
        $('form').attr('method', 'post');
    }, 1000);
</script>
EOL;
        return $template;
    }
}
