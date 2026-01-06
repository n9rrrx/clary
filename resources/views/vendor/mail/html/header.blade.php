@props(['url', 'logoCid' => ''])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block; text-decoration: none;">
@if (trim($slot) === 'Laravel' || trim($slot) === 'Clary' || trim($slot) === config('app.name'))
@if($logoCid)
<img src="{{ $logoCid }}" alt="Clary" width="40" height="40" style="vertical-align: middle; margin-right: 8px;">
@endif
<span style="font-size: 24px; font-weight: bold; color: #2563eb; vertical-align: middle;">Clary</span>
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
