@extends('layouts.app')

@section('content')
<!-- History Section -->
<div class="mb-12" style="margin:30px">
    <h2 class="text-2xl font-bold text-center text-gray-900 mb-8" style="margin-bottom:20px">Recently Visited</h2>
    <div class="space-y-4">
        @foreach ($history as $item)
            <div class="bg-white border border-gray-200 rounded-lg hover:shadow-md transition-shadow duration-300" style="margin-bottom:10px">
                <div style="display:flex; align-items: center; justify-content: space-between; margin:0; padding: 10px" class="flex justify-between items-center">
                    <!-- Theme or Article Name -->
                    <div>
                        @if ($item->type === 'theme')
                            <strong>Theme:</strong>
                            @if ($item->theme)
                                <a style="color: #111827" href="{{ route('themes.show', $item->item_id) }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                                    {{ $item->theme->name }} <!-- Assuming you have a relationship -->
                                </a>
                            @else
                                <span style="color: #999;">Theme not found</span>
                            @endif
                        @else
                            <strong>Article:</strong>
                            @if ($item->article)
                                <a style="color: #111827" href="{{ route('articles.show', $item->item_id) }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                                    {{ $item->article->title }} <!-- Assuming you have a relationship -->
                                </a>
                            @else
                                <span style="color: #999;">Article not found</span>
                            @endif
                        @endif
                    </div>

                    <!-- Visited Time -->
                    <p class="text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($item->visited_at)->format('M d, Y H:i') }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection