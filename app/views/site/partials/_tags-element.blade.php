<select id="tags" name="tags[]" multiple class="auto-submit">
@foreach($tagsselect['options'] AS $tag)
    <optgroup label="{{ $tag['parent'] }}">
        @foreach($tag['tags'] AS $subtagid => $subtag)
        	<option value="{{ $subtagid }}"@if(isset($tagsselect['selected'][$subtagid])) selected @endif> {{ $subtag }} </option>
		@endforeach
    </optgroup>
@endforeach
</select>