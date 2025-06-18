<div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('breeder-categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name{{ $category->id }}" class="form-label">Name *</label>
                        <input type="text" class="form-control" id="name{{ $category->id }}" name="name" value="{{ $category->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="slug{{ $category->id }}" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug{{ $category->id }}" name="slug" value="{{ $category->slug }}">
                    </div>
                    <div class="mb-3">
                        <label for="description{{ $category->id }}" class="form-label">Description</label>
                        <textarea class="form-control" id="description{{ $category->id }}" name="description" rows="3">{{ $category->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image{{ $category->id }}" class="form-label">Image</label>
                        @if($category->image)
                            <div class="mb-2">
                                <img src="{{ asset('image/'.$category->image) }}" alt="{{ $category->name }}" width="100" class="img-thumbnail mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remove_image{{ $category->id }}" name="remove_image" value="1">
                                    <label class="form-check-label" for="remove_image{{ $category->id }}">
                                        Remove current image
                                    </label>
                                </div>
                            </div>
                        @endif
                        <input class="form-control" type="file" id="image{{ $category->id }}" name="image" accept="image/*">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="order{{ $category->id }}" class="form-label">Order</label>
                            <input type="number" class="form-control" id="order{{ $category->id }}" name="order" value="{{ $category->order }}" min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check form-switch pt-3">
                                <input class="form-check-input" type="checkbox" id="is_active{{ $category->id }}" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active{{ $category->id }}">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>