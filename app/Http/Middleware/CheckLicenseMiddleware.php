<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CheckLicenseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {

        $response = Http::get('https://lock.smk-almuttaqien.sch.id/api/validate/host/' . $request->getHost() . '/3');


        if (!$response->successful() || ($response->json()['status'] ?? null) != 200) {
            $html = $this->generateErrorMessage($response->json()['message'] ?? 'Unknown error');


            return response($html, 403);
        }

        return $next($request);
    }

    /**
     * Generates an error message HTML to be displayed to the user.
     *
     * @param string $message The message to be displayed.
     * @return string The generated HTML string.
     */
    protected function generateErrorMessage(string $message): string
    {
        $search = '<%returnmessage%>';
        $replace = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        $html = "<div align='center'>
            <table width='100%' border='0' style='padding:15px; border-color:#F00; border-style:solid; background-color:#FF6C70; font-family:Tahoma, Geneva, sans-serif; font-size:22px; color:white;'>
                <tr>
                    <td><b>Please contact your developer for update aplication.!!!<br> <%returnmessage%> </b></td>
                </tr>
            </table>
        </div>";

        return str_replace($search, $replace, $html);
    }
}
