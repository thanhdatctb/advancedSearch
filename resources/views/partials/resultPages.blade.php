<div class="card-footer">
    <nav aria-label="Contacts Page Navigation">
        <ul class="pagination justify-content-center m-0">
{{--            --}}
            @for($i=1; $i <= $pages; $i++)
                @if($i==$page)
                    <li class="page-item active"><a class="page-link" href="#">{{$i}}</a></li>
                @else
                     <li class="page-item"><a class="page-link" href="/result/{{$domain}}/{{$type}}/{{$keyword}}/{{$i}}/{{$limit}}">{{$i}}</a></li>
                @endif
            @endfor
        </ul>
    </nav>
</div>
