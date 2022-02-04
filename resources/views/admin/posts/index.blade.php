@extends('layouts.admin')

@section('title') | Elenco post @endsection

@section('content')
<div class="container">
    <div class="row">
        <h1>
          Elenco posts
        </h1>

        <table class="table">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">TITOLO</th>
              <th scope="col">TESTO</th>
              <th scope="col">MODIFICA</th>
              <th scope="col">ELIMINA</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($posts as $post)
              <tr>
                <th scope="row">{{$post->id}}</th>
                <td>{{$post->title}}</td>
                <td>{{$post->content}}</td>
                <td>
                  <button type="button" class="btn btn-success">
                    <a href="{{route('admin.post.edit', $post)}}" style="color: white; text-decoration:none;"> Modifica</a>
                   </button>
                </td>
                <td>

                  <form 
                  action="{{route('admin.post.destroy', $post)}}" method="POST"
                  onsubmit = "return confirm('Confermi di eliminare {{$post->title}}?')">
                  @csrf
                  @method('DELETE')
                    <button type="submit" class="btn btn-danger">Elimina</button>
                  </form>
                  

                </td>
              </tr> 
            @endforeach
            
          </tbody>
        </table>

    </div>
</div>
@endsection
