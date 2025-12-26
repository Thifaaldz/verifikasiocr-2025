@if ($record && $record->ijazah_path)
<a href="{{ asset('storage/'.$record->ijazah_path) }}" target="_blank">
    <img src="{{ asset('storage/'.$record->ijazah_path) }}" class="max-w-[200px] border-2 border-gray-500 rounded p-1 cursor-pointer" />
</a>
@else
<span class="text-gray-500">Belum ada ijazah diupload</span>
@endif



