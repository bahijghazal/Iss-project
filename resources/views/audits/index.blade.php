@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h1 class="fw-bold mb-4">Security Audit Logs</h1>

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Event</th>
                        <th>Details</th>
                        <th>IP Address</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>{{ $log->user_id ?? 'Guest' }}</td>
                            <td class="fw-bold">{{ $log->event }}</td>
                            <td>
                                @if($log->meta)
                                    <pre class="small mb-0">{{ json_encode(json_decode($log->meta), JSON_PRETTY_PRINT) }}</pre>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $log->ip }}</td>
                            <td>{{ $log->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>

</div>
@endsection

