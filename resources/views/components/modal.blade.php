<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">{{ $buttonText }}</button>

    <!-- Modal -->
    <div class="modal fade" id="{{$modalId}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">{{ $title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ $url }}" method="post">
                    <div class="modal-body">
                        @csrf
                         @if (!in_array(strtolower($method), ['post', 'get']))
                            @method($method)
                        @endif
                        {{ $slot }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">tutup</button>
                        <button type="submit" class="btn btn-primary">{{ $btnTutup }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>