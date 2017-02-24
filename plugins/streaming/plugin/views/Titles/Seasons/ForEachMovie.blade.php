@if (isset($episode) && Helpers::hasLinks($episode))
    <div class="status">{{ trans('stream::main.availToStream') }}</div>
@endif