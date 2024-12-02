@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Daftar Tugas</h1>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">Tambah Tugas</a>
            <form action="{{ route('tasks.index') }}" method="GET" class="mt-2">
                <input type="text" name="search" placeholder="Cari tugas..." class="form-control" value="{{ request('search') }}">
                <button type="submit" class="btn btn-secondary mt-2">Cari</button>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>
                            <td>
                                <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $tasks->links() }}
        </div>
    </div>
@endsection
