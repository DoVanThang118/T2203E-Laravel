<div class="form-group">
    <label >{{$label}}</label>
    <input type="{{$type}}" value="{{old($key)}}" name={{$key}}
    class="form-control @error($key) is-invalid @enderror"
    @if($required) required @endif >
    @error($key)
    <p class="text-danger">{{$message}}</p>
    @enderror
</div>