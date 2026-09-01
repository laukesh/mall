@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>

            <div class="text-muted small">
                Contract:
                {{ $contract->contract_number }}
            </div>

            <h4 class="mb-1">
                Upload Deliverable
            </h4>

            <div class="text-muted">

                {{ $milestone->milestone_number }}
                -
                {{ $milestone->milestone_title }}

            </div>

        </div>


        <a
            href="{{ route(
                'admin.procurement.tenders.contracts.milestones.documents.index',
                [
                    'procurementTender' => $procurementTender,
                    'contract' => $contract,
                    'milestone' => $milestone,
                ]
            ) }}"
            class="btn btn-outline-secondary"
        >
            Back
        </a>

    </div>


    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        method="POST"
        enctype="multipart/form-data"
        action="{{ route(
            'admin.procurement.tenders.contracts.milestones.documents.store',
            [
                'procurementTender' => $procurementTender,
                'contract' => $contract,
                'milestone' => $milestone,
            ]
        ) }}"
    >

        @csrf


        <div class="card">

            <div class="card-header">

                <strong>
                    Deliverable Document Details
                </strong>

            </div>


            <div class="card-body">

                <div class="row g-3">


                    {{-- TITLE --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Document Title

                            <span class="text-danger">
                                *
                            </span>

                        </label>

                        <input
                            type="text"
                            name="document_title"
                            class="form-control"
                            value="{{ old('document_title') }}"
                            placeholder="Site Mobilization Report"
                            required
                        >

                    </div>


                    {{-- NUMBER --}}

                    <div class="col-md-3">

                        <label class="form-label">
                            Document Number
                        </label>

                        <input
                            type="text"
                            name="document_number"
                            class="form-control"
                            value="{{ old('document_number') }}"
                            placeholder="DOC-001"
                        >

                    </div>


                    {{-- TYPE --}}

                    <div class="col-md-3">

                        <label class="form-label">
                            Document Type
                        </label>

                        <select
                            name="document_type"
                            class="form-select"
                        >

                            <option value="">
                                -- Select --
                            </option>

                            <option
                                value="Completion Report"
                                @selected(
                                    old('document_type')
                                    === 'Completion Report'
                                )
                            >
                                Completion Report
                            </option>

                            <option
                                value="Inspection Report"
                                @selected(
                                    old('document_type')
                                    === 'Inspection Report'
                                )
                            >
                                Inspection Report
                            </option>

                            <option
                                value="Certificate"
                                @selected(
                                    old('document_type')
                                    === 'Certificate'
                                )
                            >
                                Certificate
                            </option>

                            <option
                                value="Drawing"
                                @selected(
                                    old('document_type')
                                    === 'Drawing'
                                )
                            >
                                Drawing
                            </option>

                            <option
                                value="Photograph"
                                @selected(
                                    old('document_type')
                                    === 'Photograph'
                                )
                            >
                                Photograph
                            </option>

                            <option
                                value="Test Report"
                                @selected(
                                    old('document_type')
                                    === 'Test Report'
                                )
                            >
                                Test Report
                            </option>

                            <option
                                value="Other"
                                @selected(
                                    old('document_type')
                                    === 'Other'
                                )
                            >
                                Other
                            </option>

                        </select>

                    </div>


                    {{-- PROGRESS --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Related Progress Update

                        </label>

                        <select
                            name="procurement_milestone_progress_id"
                            class="form-select"
                        >

                            <option value="">
                                -- Not Linked --
                            </option>

                            @foreach($progressUpdates as $progress)

                                <option
                                    value="{{ $progress->id }}"
                                    @selected(
                                        old(
                                            'procurement_milestone_progress_id'
                                        ) == $progress->id
                                    )
                                >

                                    {{
                                        $progress->progress_date
                                            ?->format('d-m-Y')
                                    }}

                                    -

                                    {{
                                        $progress->progress_percentage
                                    }}%

                                </option>

                            @endforeach

                        </select>

                        <div class="form-text">

                            Optionally link this document to
                            a specific progress update.

                        </div>

                    </div>


                    {{-- FILE --}}

                    <div class="col-md-6">

                        <label class="form-label">

                            Document File

                            <span class="text-danger">
                                *
                            </span>

                        </label>

                        <input
                            type="file"
                            name="document"
                            class="form-control"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png"
                            required
                        >

                        <div class="form-text">

                            Allowed:
                            PDF, DOC, DOCX, XLS, XLSX,
                            JPG, JPEG, PNG.

                            Maximum size: 50 MB.

                        </div>

                    </div>


                    {{-- DESCRIPTION --}}

                    <div class="col-12">

                        <label class="form-label">
                            Description
                        </label>

                        <textarea
                            name="description"
                            class="form-control"
                            rows="5"
                            placeholder="Describe this deliverable document..."
                        >{{ old('description') }}</textarea>

                    </div>

                </div>

            </div>

        </div>


        <div class="d-flex justify-content-end gap-2 mt-4">

            <a
                href="{{ route(
                    'admin.procurement.tenders.contracts.milestones.documents.index',
                    [
                        'procurementTender' => $procurementTender,
                        'contract' => $contract,
                        'milestone' => $milestone,
                    ]
                ) }}"
                class="btn btn-outline-secondary"
            >
                Cancel
            </a>


            <button
                type="submit"
                class="btn btn-primary"
            >
                Upload Document
            </button>

        </div>

    </form>

</div>

@endsection