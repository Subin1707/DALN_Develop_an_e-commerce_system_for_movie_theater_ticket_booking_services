<div class="blog_1l3 mt-4">
    <h3>Recent Comments ({{ $comments->total() }})</h3>
</div>
<div class="blog_1l5 mt-3">
    @forelse($comments as $comment)
        <div class="blog_1l5i row mb-3">
            
            <div class="col-md-10 col-10">
                <div class="blog_1l5ir">
                    <h5>
                        <a href="#">{{ $comment->author?->name ?? 'Khách' }}</a>
                        <span class="font_14 col_light">/ {{ $comment->created_at->format('d/m/Y') }}</span>
                    </h5>
                    <p class="font_14">{{ $comment->content }}</p>
                    <h6 class="font_14 mb-0 mt-3">
                        <a class="button p-3 pt-2 pb-2" href="#">Reply</a>
                    </h6>
                </div>
            </div>
        </div>
        <hr>
    @empty
        <p>Chưa có bình luận nào.</p>
    @endforelse

    {{-- Phân trang --}}
    <div class="mt-3">
        {{ $comments->links() }}
    </div>
</div>
