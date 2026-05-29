<div>
    <h2>Edit Data</h2>

    <form action="{{ route('your.update.route', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                value="{{ old('name', $item->name) }}"
            >
        </div>

        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description">
                {{ old('description', $item->description) }}
            </textarea>
        </div>

        <button type="submit">
            Update
        </button>
    </form>
</div>