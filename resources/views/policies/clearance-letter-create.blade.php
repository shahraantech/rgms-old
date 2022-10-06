@extends('setup.master')

@section('content')
    <div class="page-wrapper">

        <!-- Page Content -->
        <div class="content container-fluid">

            <div class="card" id="tablePrint" contenteditable="true">
                <div class="card-body">
                    <button class="btn btn-white btn-sm no-print float-right" id="printBtn"><i class="fa fa-print fa-lg mr-1" aria-hidden="true"></i>Print</button>
                    <table class="table border-0 mb-5">
                        <h2 class="text-center mt-5 mb-4"><u>CLEARANCE CERTIFICATE</u></h2>
                        <tr style="border: none;">
                            <td style="border: none;">To: _________</td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;">Date: &nbsp <u
                                    class="font-weight-bold">{{ $employee->created_at->format('Y-m-d') }}</u></td>
                        </tr>
                    </table>

                    <p>Mr. /Ms. &nbsp <u class="font-weight-bold">{{ $employee->name }}</u> &nbsp
                        P.#_________________working in &nbsp <u class="font-weight-bold">{{ $companyName }}</u> </p>
                    <p>Department at &nbsp <u class="font-weight-bold">{{ $employee->depart->departments }}</u> &nbsp as
                        &nbsp <u class="font-weight-bold">{{ $employee->desig_name }}</u> &nbsp has left the
                        company w.e.f.__________________________.You are</p>
                    <p class="mb-4">requested to check and left us have your confirmation whether the assets in his / her
                        possession (if
                        any) have been recieved adn following amounts are recivable/payable by to the leaving employee:</p>



                    @if (count($asign_assets) > 0)
                        <table class="table mb-4">
                            <tr>
                                <th>Assign Asset</th>
                                <th>Comments</th>
                                <th>Receivable</th>
                                <th>Payable</th>
                            </tr>
                            @isset($asign_assets)
                                @foreach ($asign_assets as $asign_asset)
                                    <tbody>
                                        <tr>
                                            <td>{{ $asign_asset->assets->title }}</td>
                                            <td></td>
                                            <td>
                                                @if ($asign_asset->is_active == 1)
                                                    <i class="fa fa-check text-success"></i>
                                                @elseif ($asign_asset->is_active == 0)
                                                    <i class="fa fa-close text-danger"></i>
                                                @endif
                                            </td>
                                            <td></td>
                                        </tr>
                                @endforeach
                            @endisset
                            </tbody>
                        </table>
                    @endif







                    <p class="mb-4">Last day worked by the employee____________ <br>
                        At the time of giving final clearance please ensure that there is nothing outstanding against the
                        employee mentioned above, as any discrepancy may cause unnessary loss to the Company. Kindly let us
                        have your comments latest within a fortnight on receipt of this note.
                    </p>


                    <table class="table border-0 mb-5">
                        <tr style="border: none;">
                            <td style="border: none;">Thanking You.</td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;" class="font-weight-bold">Signature of outgoing employee </td>
                        </tr>
                        <tr style="border: none;">
                            <td style="border: none;" class="font-weight-bold">HUMAN RESOURCE DEPARTMENT</td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;" class="font-weight-bold">Signature of Manager/HOD <br> Name: </td>
                        </tr>
                        <tr style="border: none;">
                            <td style="border: none;" class="font-weight-bold">Signature and Clearance from accounts
                                Department</td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;" class="font-weight-bold">Signature of GMD or Managing Partner <br>
                                of the The A Team </td>
                        </tr>
                        <tr style="border: none;">
                            <td style="border: none;" class="font-weight-bold">Signature and Clearance from IT Departmant
                            </td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;"></td>
                            <td style="border: none;" class="font-weight-bold"> </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
        <!-- /Page Content -->

    </div>

    <script>
        $(document).ready(function() {

            $('#printBtn').on('click', function() {
                $.print("#tablePrint");
            });

        });
    </script>
@endsection
