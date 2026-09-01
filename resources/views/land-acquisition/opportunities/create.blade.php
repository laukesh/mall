@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="mb-4">

        <h3>
            Add Land Opportunity
        </h3>

        <p class="text-muted">
            Register a potential land acquisition opportunity.
        </p>

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
        action="{{ route('admin.land.opportunities.store') }}">

        @csrf


        {{-- Basic Information --}}

        <div class="card mb-4">

            <div class="card-header">

                <strong>
                    Opportunity Information
                </strong>

            </div>


            <div class="card-body">

                <div class="row">


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Opportunity No. *
                        </label>

                        <input
                            type="text"
                            name="opportunity_no"
                            value="{{ old('opportunity_no') }}"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="col-md-8 mb-3">

                        <label class="form-label">
                            Opportunity Name *
                        </label>

                        <input
                            type="text"
                            name="opportunity_name"
                            value="{{ old('opportunity_name') }}"
                            class="form-control"
                            required
                        >

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Source
                        </label>

                        <input
                            type="text"
                            name="source"
                            value="{{ old('source') }}"
                            class="form-control"
                            placeholder="Broker, Direct, Referral..."
                        >

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Identified Date
                        </label>

                        <input
                            type="date"
                            name="identified_date"
                            value="{{ old('identified_date') }}"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Status *
                        </label>

                        <select
                            name="status"
                            class="form-select"
                            required>

                            <option value="New">
                                New
                            </option>

                            <option value="Under Evaluation">
                                Under Evaluation
                            </option>

                            <option value="Approved">
                                Approved
                            </option>

                            <option value="Rejected">
                                Rejected
                            </option>

                            <option value="On Hold">
                                On Hold
                            </option>

                        </select>

                    </div>


                </div>

            </div>

        </div>


        {{-- Location --}}

        <div class="card mb-4">

            <div class="card-header">

                <strong>
                    Location
                </strong>

            </div>


            <div class="card-body">

                <div class="mb-3">

                    <label class="form-label">
                        Location
                    </label>

                    <textarea
                        name="location_text"
                        rows="3"
                        class="form-control"
                        placeholder="Enter location details"
                    >{{ old('location_text') }}</textarea>

                </div>

            </div>

        </div>


        {{-- Area & Cost --}}

        <div class="card mb-4">

            <div class="card-header">

                <strong>
                    Estimated Area & Cost
                </strong>

            </div>


            <div class="card-body">

                <div class="row">


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Estimated Area
                        </label>

                        <input
                            type="number"
                            step="0.0001"
                            name="estimated_area"
                            value="{{ old('estimated_area') }}"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Area Unit
                        </label>

                        <select
                            name="area_unit"
                            class="form-select">

                            <option value="">
                                Select Unit
                            </option>

                            <option value="sqft">
                                Square Feet
                            </option>

                            <option value="sqm">
                                Square Meter
                            </option>

                            <option value="acre">
                                Acre
                            </option>

                            <option value="hectare">
                                Hectare
                            </option>

                        </select>

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Estimated Acquisition Cost
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="estimated_acquisition_cost"
                            value="{{ old('estimated_acquisition_cost') }}"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Currency
                        </label>

                        <input
                            type="text"
                            name="currency"
                            value="{{ old('currency', 'INR') }}"
                            class="form-control"
                        >

                    </div>

                </div>

            </div>

        </div>


        {{-- Remarks --}}

        <div class="card mb-4">

            <div class="card-header">

                <strong>
                    Remarks
                </strong>

            </div>

            <div class="card-body">

                <textarea
                    name="remarks"
                    rows="4"
                    class="form-control"
                >{{ old('remarks') }}</textarea>

            </div>

        </div>


        {{-- Buttons --}}

        <div class="d-flex justify-content-end">

            <a
                href="{{ route('admin.land.opportunities.index') }}"
                class="btn btn-secondary me-2">

                Cancel

            </a>


            <button
                type="submit"
                class="btn btn-primary">

                Save Opportunity

            </button>

        </div>

    </form>

</div>

@endsection