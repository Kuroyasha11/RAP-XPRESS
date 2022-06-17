  <style>
      table,
      th,
      td {
          border: 1px solid black;
          border-collapse: collapse;
          font-family: 'Times New Roman';
          font-size: 10px;
      }

  </style>

  <table border="1" width="100%">
      <tr>
          <td style=" width:100%; height:5%; padding:5px;" align="CENTER">
              <img src="{{ asset('assets/image/Logo/rap-resi.jpg') }}" alt="" width="100%" height="7%">
              {{-- <font size="6"><strong>RAP-XPRESS</strong></font> --}}
          </td>
          {{-- <td style=" width:70%; height:5%; padding:5px;" align="CENTER">
              <img src="{{ asset('assets/image/Logo/RAP.png') }}" alt="" width="30%" height="7%">
              <font size="6"><strong>RAP-XPRESS</strong></font>
          </td> --}}
      </tr>
  </table>
  ----------------------------------------------------------
  <table border="1" width="100%">
      <tr>
          <td style=" width:100%; height:5%; padding:10px;" align="CENTER">
              <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($package->slug, 'C128') }}"
                  alt="{{ $package->slug }}" />
          </td>
      </tr>
      <tr>
          <td style=" width:100%; height:3%;" align="CENTER">
              <strong>NO RESI : {{ $package->slug }}</strong>
          </td>
      </tr>
      <tr>
          <td style=" width:100%; height:3%;" align="CENTER">
              JENIS LAYANAN : {{ $package->shipping->nama }} @if ($package->cod == 1)
                  | CoD (Cash on Delivery)
              @endif
          </td>
      </tr>
  </table>
  ----------------------------------------------------------
  <table border="1" width="100%">
      <tr>
          <td style=" width:50%; height:5%;" align="CENTER" rowspan="4">
              <strong>{{ $package->nama }}</strong>
          </td>
          <td style=" width:50%; height:3%;" align="LEFT">
              Harga : @IDR($package->hargapaket)
          </td>
      </tr>
      <tr>
          <td style=" width:50%; height:3%;" align="LEFT">
              Jumlah : {{ $package->jumlah }}
          </td>
      </tr>
      <tr>
          <td style=" width:50%; height:3%;" align="LEFT">
              Ongkir : @IDR($package->shipping->harga)
          </td>
      </tr>
      <tr>
          <td style=" width:50%; height:3%;" align="LEFT">
              Total : @IDR($package->hargapaket + $package->shipping->harga)
          </td>
      </tr>
  </table>
  ----------------------------------------------------------
  <table style="border: none;" width="100%">
      <tr>
          <td style="border: none; width:100%; height:5%;" align="CENTER" colspan="2">
              PENERIMA
          </td>
      </tr>
      <tr>
          <td style="border: none; width:30%;" align="LEFT">
              Nama
          </td>
          <td style="border: none; width:70%;" align="LEFT">
              : {{ $package->namapenerima }}
          </td>
      </tr>
      <tr>
          <td style="border: none; width:30%;" align="LEFT">
              Alamat
          </td>
          <td style="border: none; width:70%;" align="LEFT">
              : {{ $package->alamat }}
          </td>
      </tr>
      <tr>
          <td style="border: none; width:30%;" align="LEFT">
              Telepon
          </td>
          <td style="border: none; width:70%;" align="LEFT">
              : {{ $package->no_hp }}
          </td>
      </tr>
  </table>
  ----------------------------------------------------------
  <table style="border: none;" width="100%">
      <tr>
          <td style="border: none; width:100%; height:5%;" align="CENTER" colspan="2">
              PENGIRIM
          </td>
      </tr>
      @if ($package->author->is_admin)
          <tr>
              <td style="border: none; width:30%;" align="LEFT">
                  Nama
              </td>
              <td style="border: none; width:70%;" align="LEFT">
                  : {{ $package->namapemohon }}
              </td>
          </tr>
          <tr>
              <td style="border: none; width:30%;" align="LEFT">
                  Telepon
              </td>
              <td style="border: none; width:70%;" align="LEFT">
                  : {{ $package->telepon }}
              </td>
          </tr>
      @else
          <tr>
              <td style="border: none; width:30%;" align="LEFT">
                  Nama
              </td>
              <td style="border: none; width:70%;" align="LEFT">
                  : {{ $package->author->name }}
              </td>
          </tr>
          <tr>
              <td style="border: none; width:30%;" align="LEFT">
                  Alamat
              </td>
              <td style="border: none; width:70%;" align="LEFT">
                  : {{ $user->account->alamat }}
              </td>
          </tr>
          <tr>
              <td style="border: none; width:30%;" align="LEFT">
                  Telepon
              </td>
              <td style="border: none; width:70%;" align="LEFT">
                  : {{ $user->account->wa }} / {{ $user->no_hp }}
              </td>
          </tr>
      @endif
  </table>
  ----------------------------------------------------------
  <table border="1" width="100%">
      <tr>
          <td style=" border:none; width:30%; height:3%;" align="LEFT">
              KETERANGAN
          </td>
          <td style=" border:none; width:70%; height:3%;" align="LEFT">
              : {{ $package->keterangan }}
          </td>
      </tr>
  </table>
