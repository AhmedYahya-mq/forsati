<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stevebauman\Location\Facades\Location;
use Symfony\Component\HttpFoundation\Response;

class LogVisits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has(key: 'visited')) {
            $ip = $request->ip();
            $this->storeVisitInfo(ip: $ip);
            Session::put(key: 'visited', value: true);
        }

        return $next($request);
    }

    /**
     * تخزين معلومات الزيارة في قاعدة البيانات.
     *
     * @param  string  $ip
     * @return void
     */
    private function storeVisitInfo($ip)
    {
        // إعداد القارئ لقاعدة بيانات GeoIP
        $loaction = Location::get($ip);
        try {
            $sessionId=Session::getId();

            // تخزين معلومات الزيارة في قاعدة البيانات
            $visit = Visit::create([
                'ip_address' => $ip ?? '0.0.0.0',
                'country_id' => $loaction->countryCode ?? 'YE',
                'country_name' => $loaction->countryName ?? 'YEMEN',
                'city' =>  $loaction->cityName ?? 'Unknown',
                'region' =>  $loaction->regionName ?? 'Unknown',
                'session_id' => $sessionId,
            ]);
            $visit->country()->associate($visit->country_id);
        } catch (\Exception $e) {
            // يمكن إضافة تسجيل للأخطاء هنا
            \Illuminate\Support\Facades\Log::error('Error logging visit: ' . $e->getMessage());
        }
    }
}
