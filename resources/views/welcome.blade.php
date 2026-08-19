<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f7fb;
            color: #1f2937;
        }
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            padding: 24px;
            margin-bottom: 24px;
        }
        h1, h2 {
            margin-top: 0;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-top: 20px;
        }
        .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        label {
            font-size: 14px;
            font-weight: 600;
        }
        input, select, button {
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            font-size: 14px;
        }
        input:focus, select:focus {
            outline: 2px solid #93c5fd;
            border-color: #60a5fa;
        }
        .actions {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 20px;
        }
        .btn {
            background: #2563eb;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn.secondary {
            background: #e5e7eb;
            color: #111827;
        }
        .btn.danger {
            background: #dc2626;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            background: #f3f4f6;
        }
        .alert {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .empty {
            color: #6b7280;
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Family Records</h1>

            @if(session('success'))
                <div class="alert">{{ session('success') }}</div>
            @endif

            <h2>{{ isset($family) ? 'Edit Family Member' : 'Add Family Member' }}</h2>

            <form method="POST" action="{{ isset($family) ? route('families.update', $family->id) : route('families.store') }}">
                @csrf
                @if(isset($family))
                    @method('PUT')
                @endif

                <div class="form-grid">
                    <div class="field">
                        <label for="name">Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $family->name ?? '') }}" required>
                    </div>

                    <div class="field">
                        <label for="relation">Relation</label>
                        <input id="relation" type="text" name="relation" value="{{ old('relation', $family->relation ?? '') }}" required>
                    </div>

                    <div class="field">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select gender</option>
                            <option value="Male" {{ old('gender', $family->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $family->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $family->gender ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="dob">Date of Birth</label>
                        <input id="dob" type="date" name="dob" value="{{ old('dob', $family->dob ?? '') }}" required>
                    </div>
                </div>

                <div class="actions">
                    <button class="btn" type="submit">{{ isset($family) ? 'Update' : 'Add' }}</button>
                    @if(isset($family))
                        <a class="btn secondary" href="{{ route('families.index') }}">Cancel</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="card">
            <h2>Family List</h2>

            @if($families->isEmpty())
                <p class="empty">No family members yet.</p>
            @else
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Relation</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($families as $member)
                            <tr>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->relation }}</td>
                                <td>{{ $member->gender }}</td>
                                <td>{{ $member->dob }}</td>
                                <td>
                                    <div class="actions" style="margin-top: 0;">
                                        <a class="btn secondary" href="{{ route('families.edit', $member->id) }}">Edit</a>
                                        <form method="POST" action="{{ route('families.destroy', $member->id) }}" onsubmit="return confirm('Delete this family member?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>
</html>