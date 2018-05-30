@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block" id="pesan">
        <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $message }}</strong>
        </div>
      @endif
    </div>
  </div>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="alert alert-info alert-block" id="info">
            <button type="button" class="close" data-dismiss="alert">×</button> 
            <strong>{{$info['status']}}</strong>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-responsive">
            <form action="{{ url('/home/create') }}" method="post">
              {{ csrf_field() }}
              <tr>
                <td>
                  <input class="form-control" name="keterangan" placeholder="Keterangan ..."></input>
                </td>
                <td>
                  <button type="submit" name="btnIn" class="btn btn-primary" {{$info['btnIn']}}>Absen Masuk</button>
                  <button type="submit" name="btnOut" class="btn btn-default" {{$info['btnOut']}}>Absen Keluar</button>
                </td>
              </tr>
            </form>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">Riwayat Absensi {{ Auth::user()->name }}</div>
        <div class="panel-body">
          <table class="table table-responsive table-bordered table-hover">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              @forelse($list_absen as $absen)
              <tr>
                <td>{{date('d-F-Y',strtotime($absen->tanggal))}}</td>
                <td>{{$absen->jam_masuk}}</td>
                <td>{{$absen->jam_keluar}}</td>
                <td>{{$absen->keterangan}}</td>
              </tr>
              @empty()
              <tr>
                <td colspan="4"><center><b>Hello {{ Auth::user()->name }}, kamu tidak mempunyai riwayat absen</b></center></td>
              </tr>
              @endforelse
            </tbody>
          </table>
          {!! $list_absen->render() !!}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection()

