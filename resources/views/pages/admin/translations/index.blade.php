@extends('layouts.main')


@section('content')
 
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Translations</h3>
        <div class="card-tools float-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTranslationModal">
                Add New Translation
            </button>
        </div>
    </div>
    <div class="card-body">
        <table id="translations-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Language</th>
                    <th>Keyword</th>
                    <th>Transalation</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="modal fade" id="addTranslationModal" tabindex="-1" role="dialog" aria-labelledby="addTranslationLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form id="add-translation-form">
            @csrf   
            <div class="modal-header">
                <h5 class="modal-title" id="addTranslationLabel">Add New Translation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <label for="locale">Locale</label>
                        <select class="form-control" name="locale" id="locale">
                            <option value="">Select one</option>
                            @foreach(config('app.languages') as $key => $locale)
                            <option value="{{ $key }}">{{ $locale }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="key">Keyword</label>
                        <input type="text" class="form-control" name="key" id="key" placeholder="Enter translation key">
                    </div>
                    <div class="form-group">
                        <label for="value">Translation</label>
                        <input type="text" class="form-control" name="value" id="value" placeholder="Enter translation value">
                    </div>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Translation</button>
            </div>
            </form>

        </div>
    </div>
</div>

    @push('scripts')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <!-- <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


    <script>
        $(document).ready(function() {

            window.deleteTranslation = function(id) {
                if (confirm('Are you sure you want to delete this translation?')) {
                    $.ajax({
                        url: '{{ route('translations.destroy', ['id' => ':id']) }}'.replace(':id', id),
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('#translations-table').DataTable().ajax.reload();
                        }
                    });
                }
            };

            $('#add-translation-form').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '{{ route('trans-store') }}',
                    type: 'POST',
                    data: formData,
                    success: function(data) {
                        window.location.href = '{{ route('translations.index') }}';
                    }
                });
            });

            $('#translations-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('translations.list.index') }}',
                columns: [
                    { data: 'id' },
                    { data: 'locale' },
                    { data: 'key' },
                    { data: 'value' },
                    { data: 'action', orderable: false, searchable: false }
                ],
                pagingType: 'full_numbers',
                pageLength: 5,
                lengthMenu: [
                    [5, 10, 25, 50, 100],
                    [5, 10, 25, 50, 100]
                ],
                columnDefs: [
                    {
                        targets: 4,
                        render: function(data, type, row, meta) {
                            return `<button type="button" class="btn btn-danger" onclick="deleteTranslation(${row.id})"><i class="fa fa-trash"></i></button>`;
                        }
                    }
                ]
            });

        });
    </script>
    @endpush
@endsection
