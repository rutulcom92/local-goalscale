@if (!empty($goal->tags))
    
    @php
        $tagsStr = implode(', ', $goal->tags()->orderBy('tag','ASC')->pluck('tag')->toArray());
    @endphp

    @if (strlen($tagsStr) > 15)
        
        @php
            $popoverContent = '<ul class=badge_listing_mvb>';
            foreach ($goal->tags as $key => $value) {
                $popoverContent .= '<li><span>'.$value->tag.'</span></li>';
            }
            $popoverContent .= '</ul>';

            $tagsStr = substr($tagsStr, 0, 15);
        @endphp

        {{ $tagsStr.'...' }}
        <a tabindex="0"
            class="dt-view-all-tags" 
            role="button" 
            data-html="true" 
            data-toggle="popover" 
            data-trigger="focus" 
            title="Tags for - {{ $goal->name }}"
            data-content="{{ $popoverContent }}">
            View all
        </a>
    @else
        {{ $tagsStr }}
    @endif
@endif