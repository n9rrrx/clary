@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel' || trim($slot) === 'Clary' || trim($slot) === config('app.name'))
<span style="font-size: 28px; font-weight: bold; color: #2563eb;">◆ Clary</span>
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
