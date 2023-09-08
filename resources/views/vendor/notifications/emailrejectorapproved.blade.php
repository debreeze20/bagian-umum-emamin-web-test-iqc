<style>
    body {
        font-family: Arial !important;
        background: #F3F6F9 !important;
        padding: 30px;
    }

</style>

@if($statusType == "reject")
<div style="background:#fff;width:100%;max-width:400px;padding:20px;display:block;margin:auto;">
    <img alt="Logo" src="{{asset('assets/extends/images/icon-revision.png')}}"
        style="width:230px;display:block;margin:auto;" />
    <div style="text-align:center;font-weight:600;font-size:18px;color:black;">Hey {{$name}}, Data Perlu Diperbaiki!
    </div>
    <div style="color:#5E6278;text-align:center;padding-top:15px;">Data identitas diri dan industri yang anda kirim
        perlu diperbaiki. Silahkan klik tombol dibawah ini untuk melengkapi kembali data anda.</div>
    <div style="margin-bottom:40px;text-align:center;margin-top:40px;">
        <a href="{{url('revision-industry')}}?unique={{\Illuminate\Support\Str::random(70)}}&industry={{$industryId}}"
            style="background:#F8D831;color:black;padding:15px 20px;border-radius:10px;text-decoration:none !important;font-weight:500;">
            Revisi Data
        </a>
    </div>
    <div style="color:black;font-weight:600">Keterangan Revisi</div>
    <div style="padding:10px;border-radius:5px;margin-bottom:40px;margin-top:10px;background:#F3F6F9;color:#5E6278">{{$rejectReason}}</div>
    <div style="text-align:center;margin-top:50px;margin-bottom:15px;color:black">©
        {{\Carbon\Carbon::now()->format('Y')}} - Copyright Disbudporapar Kota Surabaya. All right reserved</div>
</div>
@else
<div style="background:#fff;width:100%;max-width:400px;padding:20px;display:block;margin:auto;">
    <img alt="Logo" src="{{asset('assets/extends/images/icon-hallo.png')}}"
        style="width:230px;display:block;margin:auto;" />
    <div style="text-align:center;font-weight:600;font-size:18px;color:black;">Hey {{$name}}, Data Telah Disetujui!
    </div>
    <div style="color:#5E6278;text-align:center;padding-top:15px;">Data diri dan industri anda berhasil di setujui.
        Silahkan klik tombol dibawah ini untuk login akun anda.</div>
    <div style="margin-bottom:40px;text-align:center;margin-top:40px;">
        <a href="{{url('/login')}}"
            style="background:#F8D831;color:black;padding:15px 20px;border-radius:10px;text-decoration:none !important;font-weight:500;">
            Login
        </a>
    </div>
    <div style="text-align:center;margin-top:50px;margin-bottom:15px;color:black">©
        {{\Carbon\Carbon::now()->format('Y')}} - Copyright Disbudporapar Kota Surabaya. All right reserved</div>
</div>
@endif
