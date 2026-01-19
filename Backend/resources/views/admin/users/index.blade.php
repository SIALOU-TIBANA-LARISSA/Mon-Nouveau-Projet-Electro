@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">👤 Utilisateurs</h1>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">ID</th>
            <th class="p-3 text-left">Nom</th>
            <th class="p-3 text-left">Email</th>
            <th class="p-3 text-left">Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr class="border-t">
                <td class="p-3">{{ $user->id }}</td>
                <td class="p-3">{{ $user->name }}</td>
                <td class="p-3">{{ $user->email }}</td>
                <td class="p-3">{{ $user->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
