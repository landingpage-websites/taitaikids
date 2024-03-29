@extends('backend.layouts.master')

@push('title')
    Product Details
@endpush

@section('main-content')
    <div class="card">
        <div class="card-header" style="display: flex !important ; justify-content: space-between; align-items: center">
            <h2>Product</h2>
            <h2>
                @for ($i = 1; $i <= 5; $i++)
                    {{-- @if ($review->rate >= $i) --}}
                        <i class="fa fa-star" style="float:left;color:#F7941D;"></i>
                    {{-- @else
                        <i class="far fa-star" style="float:left;color:#F7941D;"></i>
                    @endif --}}
                @endfor
                {{-- ({{$review->rate}} stars) --}}
            </h2>

            <a href="{{ url()->previous() }}" class="shadow-sm d btn btn-sm btn-primary" style="display: inline-block">
                {{-- <i class="fas fa-download fa-sm text-white-50"></i> --}}
                back</a>
        </div>
        <div class="card-body">
            @if ($review)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Subject</th>
                            {{-- <th>Message</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $review->name }}</td>
                            <td>{{ $review->email }}</td>
                            <td>{{ $review->subject }}</td>
                            {{-- <td>{{ $review->msg }}</td> --}}
                            <td>
                                @if ($review->status == 'active')
                                    <span class="btn badge-success status-update">{{ $review->status }}</span>
                                @else
                                    <span class="btn badge-warning status-update">{{ $review->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('review.edit', $review->id) }}"
                                    class="float-left mr-1 btn btn-primary btn-sm"
                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit"
                                    data-placement="bottom"><i class="fas fa-edit"></i></a>
                                <form method="POST" action="{{ route('review.destroy', [$review->id]) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm dltBtn" data-id={{ $review->id }}
                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                        data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <section class="confirmation_part section_padding">
                    <div class="order_boxes">
                        <div class="row">
                            <div class="col-lg-6 col-lx-4">
                                <div class="order-info">
                                    <h4 class="pb-4 text-center">User Details</h4>
                                    <table class="table">
                                        <tr class="">
                                            <td>Name</td>
                                            <td> : {{ $review->user?->name }}</td>
                                        </tr>
                                        <tr class="">
                                            <td>Last Name</td>
                                            <td> : {{ $review->user?->l_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>E-mail</td>
                                            <td> : {{ $review->user?->email }}</td>
                                        </tr>
                                        <tr class="">
                                            <td>Phone</td>
                                            <td> : {{ $review->user?->phone }}</td>
                                        </tr>
                                        <tr class="">
                                            <td>Address</td>
                                            <td> : {{ $review->user?->address }}</td>
                                        </tr>
                                        <tr class="">
                                            <td>City</td>
                                            <td> : {{ $review->user?->city }}</td>
                                        </tr>
                                        <tr class="">
                                            <td>Role</td>
                                            <td> : {{ $review->user?->role }}</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-6 col-lx-4">
                                <div>
                                    <div class="shipping-info">
                                        <h4 class="pb-4 text-center">Review Message</h4>
                                        <P>
                                            {{ $review->msg }}
                                        </P>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>

                <section class="mt-5">
                    <h1 class="text-center" style="text-decoration: underline;" >Review's Photos</h1>
                    <div class="text-center">
                        {{-- @foreach ($review->images as $pto) --}}
                            <img src="/storage/{{ $review->user?->photo?? 'default/face.png' }}"
                                class="mx-auto rounded img-fluid img-thumbnail img-gallery" alt="{{$review->subject}}">
                        {{-- @endforeach --}}
                    </div>
                </section>
            @endif

        </div>
    </div>
@endsection

@push('styles')
    <style>
        .order-info,
        .shipping-info {
            background: #ECECEC;
            padding: 20px;
        }

        .order-info h4,
        .shipping-info h4 {
            text-decoration: underline;
        }

        .img-gallery {
            max-height: 250px;
        }
    </style>
@endpush
@push('scripts')
    <script>
        $('.status-update').on('click', function(e) {
            console.log('I am status update click')
            let This = this;
            $.ajax({
                'method': 'post',
                url: "{{ route('review_status.change') }}",
                data: {
                    id: '{{ $review->id }}',
                    _token: "{{ csrf_token() }}",
                },
                success: (res) => {
                    console.log(res);
                    if (res == 'inactive') {
                        $(This).text('Inactive');
                        $(This).removeClass('badge-success');
                        $(This).addClass('badge-warning');
                    } else if (res == 'active') {
                        $(This).text('Active');
                        $(This).addClass('badge-success');
                        $(This).removeClass('badge-warning');
                    } else {
                        alert('Something went wrong');
                    }
                }

            })
        })
    </script>
@endpush
