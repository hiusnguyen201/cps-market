<div class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h1 class="m-0">{{ $title }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/users">Home</a></li>
                    @if (!is_null($breadcumbs))
                        @foreach ($breadcumbs['titles'] as $index => $slice_of_bread)
                            @if (count($breadcumbs['titles']) == +$index + 1)
                                <li class="breadcrumb-item active">{{ $slice_of_bread }}</li>
                            @else
                                <li class="breadcrumb-item"><a
                                        href="{{ $breadcumbs['title_links'][+$index] }}">{{ $slice_of_bread }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
