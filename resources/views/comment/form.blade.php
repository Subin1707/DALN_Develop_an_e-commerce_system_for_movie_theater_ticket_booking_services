@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="blog_1l3 mt-4">
    <h3>Leave a Comment</h3>
</div>
<div class="blog_1l6 mt-3">
    <form action="{{ route('news.comments.store', $news->id) }}" method="POST">
        @csrf
        <div class="blog_1dt5 row mt-3">
            <div class="col-md-6">
                <div class="blog_1dt5l">
                    <textarea name="content" placeholder="Comment" class="form-control form_text" rows="5">{{ old('content') }}</textarea>
                    <div class="form-check mt-3">
                        <input type="checkbox" class="form-check-input" id="customCheck1">
                        <label class="form-check-label" for="customCheck1">
                            Save my name and email in this browser for the next time I comment.
                        </label>
                    </div>
                    <h6 class="mt-3 mb-0">
                        <button type="submit" class="button p-3 pt-2 pb-2">Comment</button>
                    </h6>
                </div>
            </div>
            <div class="col-md-6">
                <div class="blog_1dt5l">
                    <input name="name" value="{{ old('name') }}" class="form-control" placeholder="Name" type="text">
                    <input name="email" value="{{ old('email') }}" class="form-control mt-3" placeholder="Email" type="text">
                    <input name="website" value="{{ old('website') }}" class="form-control mt-3" placeholder="Website" type="text">
                </div>
            </div>
        </div>
    </form>
</div>
