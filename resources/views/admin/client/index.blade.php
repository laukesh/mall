@extends('layouts.admin')

@section('title', 'Clients')

@section('content')
<section class="section">
  <div class="section-header d-flex justify-content-between align-items-center">
    <h1>Clients</h1>
    <a href="{{ route('admin.client.create') }}" class="btn btn-primary">Add Client</a>
  </div>

  <div class="card">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-striped table-hover mb-0">
          <thead>
            <tr>
              <th>Code</th>
              <th>Client Name</th>
              <th>Type</th>
              <th>Contact</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($clients as $client)
            <tr>
              <td>{{ $client->client_code }}</td>
              <td>{{ $client->client_name }}</td>
              <td>{{ $client->client_type }}</td>
              <td>{{ $client->contact_person ?? $client->mobile ?? '-' }}</td>
              <td><span class="badge bg-{{ $client->status === 'Active' ? 'success' : 'secondary' }}">{{ $client->status }}</span></td>
              <td class="text-end">
                <a href="{{ route('admin.client.show', $client->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                <a href="{{ route('admin.client.edit', $client->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                <form action="{{ route('admin.client.destroy', $client->id) }}" method="POST" class="d-inline">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this client?')">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted py-4">No clients found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection
