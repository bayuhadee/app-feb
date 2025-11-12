<?php

namespace App\Filament\Pages\Yudisium;

use BackedEnum;
use App\Models\Yudisium;
use Filament\Pages\Page;
use App\Models\Mahasiswa;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\View;
use Filament\Support\Exceptions\Halt;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Actions\Contracts\HasActions;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;
use Hugomyb\FilamentMediaAction\Actions\MediaAction;

class DaftarYudisium extends Page implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    protected string $view = 'filament.pages.yudisium.daftar-yudisium';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;
    protected static ?string $navigationLabel = 'Yudisium';
    protected static ?string $title = 'Pendaftaran Yudisium';

    public ?array $data = [];
    public ?Mahasiswa $mahasiswa = null;
    public $yudisium;
    public $skripsi;
    public bool $is_locked = false;
    /**
     * Daftar persyaratan file yang harus diupload oleh mahasiswa yudisium.
     *
     * @var array<int, array{
     *     label: string,
     *     field: string,
     *     accept: string,
     *     note?: string,
     *     contoh?: string
     * }>
     */
    public array $requirements = [
        [
            'label' => 'File Skripsi (PDF)',
            'field' => 'file_skripsi',
            'accept' => 'application/pdf',
        ],
        [
            'label' => 'File Jurnal (PDF)',
            'field' => 'file_jurnal',
            'accept' => 'application/pdf',
        ],
        [
            'label' => 'Kwitansi Pembayaran Yudisium',
            'field' => 'file_kwitansi',
            'accept' => 'application/pdf',
        ],
        [
            'label' => 'Kwitansi Pembayaran PPPM',
            'field' => 'file_pppm',
            'accept' => 'application/pdf',
        ],
        [
            'label' => 'Kwitansi Sertifikat TOEFL & Transkrip Nilai',
            'field' => 'file_toefle',
            'accept' => 'application/pdf',
        ],
        [
            'label' => 'Foto Slide',
            'field' => 'foto_slide',
            'accept' => 'image/jpeg,image/png,image/jpg',
            'note' => 'Foto berwarna dengan ketentuan pria memakai full dress dan wanita memakai pakaian nasional.',
            'contoh' => 'assets/images/contoh-foto-yudisium-fewarmadewa-wanita.jpg',
        ],
        [
            'label' => 'Foto Biodata',
            'field' => 'foto_biodata',
            'accept' => 'image/jpeg,image/png,image/jpg',
            'note' => 'Foto hitam putih dengan ketentuan pria memakai full dress dasi panjang dan wanita memakai dasi kupu-kupu.',
            'contoh' => 'assets/images/contoh-foto-yudisium-fewarmadewa-biodata.jpg',
        ],
    ];
    public $textWa;

    public function mount()
    {
        $this->mahasiswa = Auth::user()->mahasiswa ?? null;
        $this->yudisium = $this->mahasiswa->yudisium ?? null;
        $this->skripsi = $this->mahasiswa->skripsi ?? null;
        $this->is_locked = $this->mahasiswa ? true : false;
        $this->textWa = '[FE WARMADEWA] Pendaftaran YUDISIUM mhs. atas NAMA: ' . ($this->mahasiswa->Nama ?? null) . ' NPM: ' . ($this->mahasiswa->NPM ?? null) . '   untuk divalidasi. Terimakasih';
        $this->form->fill($this->yudisium?->attributesToArray());
    }

    public function form(Schema $schema): Schema
    {
        $startStep = $this->yudisium ? (intval($this->yudisium->status_verifikasi) == 2 ? 4 : 3) : ($this->skripsi ? 2 : 1);

        return $schema
            ->record($this->yudisium)
            ->schema([
                Wizard::make([
                    Step::make('Mahasiswa')
                        ->description('Isi data untuk memeriksa kelulusan tugas akhir.')
                        ->afterValidation(function (Set $set, Get $get) {
                            $mahasiswa = Mahasiswa::with('skripsi', 'yudisium')
                                ->where('NPM', $get('check_NPM'))
                                ->where('Jurusan', $get('check_Jurusan'))
                                // ->where('NoTelp', $get('check_NoTelp'))
                                ->first();

                            // Jika data tidak ditemukan
                            if (! $mahasiswa) {
                                Notification::make()
                                    ->title('Data mahasiswa tidak ditemukan!')
                                    ->body('Harap periksa kembali NPM dan Jurusan Anda.')
                                    ->danger()
                                    ->send();

                                throw new Halt();
                            }

                            if (! $this->mahasiswa) {
                                Auth::user()->update([
                                    'NPM' => $get('check_NPM'),
                                ]);
                                Auth::user()->refresh();
                                $mahasiswa->update([
                                    'Email' => Auth::user()->email
                                ]);
                                Notification::make()
                                    ->title('Data berhasil tersimpan!')
                                    ->body('NPM Anda telah terhubung dengan akun ini.')
                                    ->success()
                                    ->send();

                                $this->mahasiswa = Auth::user()->mahasiswa;
                                $this->skripsi = $this->mahasiswa->skripsi ?? null;
                                $this->yudisium = $this->mahasiswa->yudisium ?? null;
                                $this->is_locked = true;
                                $this->dispatch('$refresh');
                            }

                            // Jika belum skripsi
                            if (! $mahasiswa->skripsi) {
                                Notification::make()
                                    ->title('Tugas akhir Anda belum selesai!')
                                    ->body('Anda belum menyelesaikan Tugas Akhir. Silahkan pastikan kelulusan terlebih dahulu.')
                                    ->danger()
                                    ->send();

                                throw new Halt();
                            }

                            // Refill form agar step berikutnya update datanya
                            // $this->form->model($this->yudisium)->fill();
                            // $this->yudisium->refresh();
                            $this->form->fill($this->yudisium?->attributesToArray());
                            $this->dispatch('$refresh');

                            Notification::make()
                                ->title('Data berhasil disimpan!')
                                ->body('Silahkan lanjut untuk melengkapi Biodata Wisudawan.')
                                ->success()
                                ->send();
                        })
                        ->schema($this->getFormCheckMahasiswa()),
                    Step::make('Biodata Wisudawan')
                        ->description('Lengkapi biodata pribadi Anda dengan benar.')
                        ->afterValidation(function (Get $get, $livewire) {
                            $state = $livewire->form->getState();
                            $this->yudisium = Yudisium::updateOrCreate(
                                [
                                    'NPM' => $state['NPM'],
                                ],
                                [
                                    'nama' => $state['nama'],
                                    'ttl' => $state['ttl'],
                                    'prodi' => $state['prodi'],
                                    'agama' => $state['agama'],
                                    'jenis_kelamin' => $state['jenis_kelamin'],
                                    'asal' => $state['asal'],
                                    'alamat' => $state['alamat'],
                                    'nama_orangtua' => $state['nama_orangtua'],
                                    'nomor_hp' => $state['nomor_hp'],
                                    'nomor_wa' => $state['nomor_wa'],
                                    'email' => $state['email'],
                                    'tanggal_lulus' => $state['tanggal_lulus'],
                                    'ipk' => $state['ipk'],
                                    'predikat_lulus' => $state['predikat_lulus'],
                                    'judul' => $state['judul'],
                                    'bekerja' => $state['bekerja'],
                                    'pekerjaan' => $state['pekerjaan'] ?? null,
                                    'nama_kantor' => $state['nama_kantor'] ?? null,
                                    'alamat_kantor' => $state['alamat_kantor'] ?? null,
                                    'telp_kantor' => $state['telp_kantor'] ?? null,
                                    'tambahan_keterampilan' => $state['keterampilan'],
                                    // 'foto_slide' => $state['foto_slide'],
                                    // 'foto_biodata' => $state['foto_biodata'],
                                    'tempat_penelitian' => $state['tempat_penelitian'],
                                    'alamat_penelitian' => $state['alamat_penelitian'],
                                    'nomor_sk' => $state['nomor_sk'],
                                    'tgl_sk' => $state['tgl_sk'],
                                    'tgl_daftar' => now(),
                                    // 'file_skripsi' => $state['file_skripsi'],
                                    // 'file_jurnal' => $state['file_jurnal'],
                                    // 'status_verifikasi' => $state['status_verifikasi'],
                                    // 'keterangan' => $state['keterangan'],
                                    // 'file_kwitansi' => $state['file_kwitansi'],
                                    // 'tgl_update' => $state['tgl_update'],
                                    // 'ids' => $state['ids'],
                                    // 'file_pppm' => $state['data'],
                                    // 'file_toefle' => $state['data'],
                                    // 'ip_address' => $state['data'],
                                    // 'id_op_validasi' => $state['data'],
                                    // 'nama_op_validasi' => $state['data'],
                                    // 'password' => $state['data'],
                                    'v2' => 0,
                                    'tgl_disetujui' => '0000-00-00 00:00:00',
                                ]
                            );
                            // $this->form->model($this->yudisium)->fill();
                            // $this->yudisium->refresh();
                            $this->form->fill($this->yudisium?->attributesToArray());
                            $this->dispatch('$refresh');

                            Notification::make()
                                ->title('Data berhasil disimpan!')
                                ->body('Silahkan lanjut untuk melengkapi file persyaratan yudisium.')
                                ->success()
                                ->send();
                        })
                        ->schema($this->getFormBiodataWisudawan()),
                    Step::make('Persyaratan Yudisium')
                        ->description('Unggah semua berkas yang diperlukan.')
                        ->afterValidation(function (Get $get, $livewire) {
                            if (intval($this->yudisium->status_verifikasi) == 1) {
                                Notification::make()
                                    ->title('Menunggu verifikasi!')
                                    ->body('File akan diverifikasi terlebih dahulu. informasi selanjutnya akan dikirim melalui Whatsapp atau silahkan akses halaman ini secara berkala.')
                                    ->info()
                                    ->send();
                                throw new Halt();
                            }
                            if (intval($this->yudisium->status_verifikasi) == 0) {
                                Notification::make()
                                    ->title('Menunggu verifikasi!')
                                    ->body('File akan diverifikasi terlebih dahulu. informasi selanjutnya akan dikirim melalui Whatsapp atau silahkan akses halaman ini secara berkala.')
                                    ->info()
                                    ->send();
                                throw new Halt();
                            }
                            if (intval($this->yudisium->status_verifikasi) == 3) {
                                Notification::make()
                                    ->title('File belum sesuai!')
                                    ->body('File yang anda lampirkan belum disetujui dengan keterangan ' . $this->yudisium->keterangan . '. Silahkan perbaiki dan upload kembali file skripsi dan file jurnal pada form dibawah ini!')
                                    ->warning()
                                    ->send();
                                throw new Halt();
                            }
                            if (intval($this->yudisium->status_verifikasi) == 2) {
                                Notification::make()
                                    ->title('File telah disetujui!')
                                    ->body('File yang telah anda lampirkan telah disetujui. Silahkan cetak berkas dibawah ini untuk dibawa ke panitia yudisium.')
                                    ->success()
                                    ->send();
                            }
                            $this->dispatch('$refresh');
                        })
                        ->schema([
                            View::make('livewire.yudisium-upload-table')
                                ->viewData([
                                    'requirements' => $this->requirements,
                                    'yudisium' => $this->yudisium,
                                ]),
                            Section::make('File Belum Sesuai!')
                                ->visible($this->yudisium && intval($this->yudisium->status_verifikasi) == 3 ? true : false)
                                ->schema([
                                    TextEntry::make('keterangan')
                                ]),
                            Section::make('Sedang diverifikasi!')
                                ->visible($this->yudisium && intval($this->yudisium->status_verifikasi) == 1 ? true : false)
                                ->description('File akan diverifikasi terlebih dahulu. informasi selanjutnya akan dikirim melalui Whatsapp atau silahkan akses halaman ini secara berkala.'),
                            Section::make('Menunggu Verifikasi!')
                                ->description('Periksa kembali semua file dan pastikan semua file berhasi terupload sebelum mengirim permintaan validasi. Silahkan kirim whatsapp dengan klik tombol dibawah ini untuk melanjutkan permintaan validasi.')
                                ->visible($this->yudisium && (intval($this->yudisium->status_verifikasi) == 0 || intval($this->yudisium->status_verifikasi) == 3) ? true : false)
                                ->schema([
                                    Actions::make([
                                        Action::make('reqValidasi')
                                            ->label('Kirim Permintaan Validasi Berkas')
                                            ->button()
                                            ->color('info')
                                            ->icon('heroicon-o-arrow-top-right-on-square')
                                            ->url(function () {
                                                $this->textWa = '[FE WARMADEWA] Pendaftaran YUDISIUM mhs. atas NAMA: ' . ($this->mahasiswa->Nama ?? null) . ' NPM: ' . ($this->mahasiswa->NPM ?? null) . '   untuk divalidasi. Terimakasih';
                                                return url('https://api.whatsapp.com/send/?phone=6287860960870&text=' . $this->textWa);
                                            })
                                            ->outlined()
                                            ->openUrlInNewTab(),
                                    ])->fullWidth(),
                                ])
                        ]),
                    Step::make('Selesai')
                        ->description('Pendaftaran Anda telah diverifikasi dan disetujui.')
                        ->schema([
                            Section::make('Berkas Yudisium')
                                ->description('File yang telah anda lampirkan telah disetujui. Silahkan cetak berkas dibawah ini untuk dibawa ke panitia yudisium.')
                                ->visible($this->yudisium && intval($this->yudisium->status_verifikasi) == 2 ? true : false)
                                ->schema([
                                    Actions::make([
                                        Action::make('cetakbiodatawisudawan')
                                            ->label('Biodata Wisudawan')
                                            ->button()
                                            ->color('danger')
                                            ->icon('heroicon-o-printer')
                                            ->url(fn(): string => route('export.biodata-wisudawan'))
                                            ->openUrlInNewTab()
                                            ->after(function () {
                                                Notification::make()
                                                    ->title('Berhasil mendownload biodata wisudawan!')
                                                    ->success()
                                                    ->send();
                                            }),
                                        Action::make('cetakbiodataalumni')
                                            ->label('Biodata Alumni')
                                            ->button()
                                            ->color('primary')
                                            ->icon('heroicon-o-printer')
                                            ->url(fn(): string => route('export.biodata-alumni'))
                                            ->openUrlInNewTab()
                                            ->after(function () {
                                                Notification::make()
                                                    ->title('Berhasil mendownload biodata alumni!')
                                                    ->success()
                                                    ->send();
                                            }),
                                        Action::make('cetakbiodatavandel')
                                            ->label('Biodata Vandel')
                                            ->button()
                                            ->color('warning')
                                            ->icon('heroicon-o-printer')
                                            ->url(fn(): string => route('export.biodata-vandel'))
                                            ->openUrlInNewTab()
                                            ->after(function () {
                                                Notification::make()
                                                    ->title('Berhasil mendownload biodata vandel!')
                                                    ->success()
                                                    ->send();
                                            }),
                                    ])->fullWidth(),
                                ])
                        ]),
                ])->startOnStep($startStep)
            ])
            ->statePath('data');
    }

    public function getFormCheckMahasiswa(): array
    {
        return [
            TextInput::make('check_NPM')
                ->label('NPM')
                ->inlineLabel()
                ->required()
                ->numeric()
                ->columnSpanFull()
                ->disabled(fn() => $this->is_locked)
                ->afterStateHydrated(function ($set, $record) {
                    $set('check_NPM', $this->mahasiswa->NPM ?? null);
                }),
            Select::make('check_Jurusan')
                ->label('Program Studi')
                ->inlineLabel()
                ->options([
                    'AKUNTANSI' => 'AKUNTANSI',
                    'MANAJEMEN' => 'MANAJEMEN',
                    'IESP' => 'IESP',
                    'AKUNTANSI PERPAJAKAN' => 'AKUNTANSI PERPAJAKAN',
                ])
                ->required()
                ->disabled(fn() => $this->is_locked)
                ->afterStateHydrated(function ($set, $record) {
                    if (!$record || $this->mahasiswa) {
                        $set('check_Jurusan', strtoupper($this->mahasiswa->Jurusan ?? null));
                    }
                }),
            // DatePicker::make('check_TglLahir')
            //     ->label('Tanggal Lahir')
            //     ->inlineLabel()
            //     ->required()
            //     ->columnSpanFull()
            //     ->disabled(fn($record) => $record ? true : false)
            //     ->afterStateHydrated(function ($set, $record) {
            //         $set('check_TglLahir', $this->mahasiswa->TglLahir ?? null);
            //     }),
            // TextInput::make('check_NoTelp')
            //     ->label('No Telepon')
            //     ->inlineLabel()
            //     ->required()
            //     ->columnSpanFull()
            //     ->disabled(fn($record) => $record ? true : false)
            //     ->afterStateHydrated(function ($set, $record) {
            //         $set('check_NoTelp', $record->NoTelp ?? null);
            //     }),

        ];
    }

    public function getFormBiodataWisudawan(): array
    {
        return [
            Section::make('Data Mahasiswa')
                ->schema([
                    TextInput::make('NPM')
                        ->label('NPM')
                        ->required()
                        ->disabled()
                        ->dehydrated(true)
                        ->afterStateHydrated(function ($set, $record) {
                            if (!$record && $this->mahasiswa) {
                                $set('NPM', $this->mahasiswa->NPM ?? null);
                            }
                        }),

                    TextInput::make('nama')
                        ->label('Nama Lengkap')
                        ->belowContent('Sesuai ijasah SMA/SMK')
                        ->required()
                        ->afterStateHydrated(function ($set, $record) {
                            if (!$record && $this->mahasiswa) {
                                $set('nama', $this->mahasiswa->Nama ?? null);
                            }
                        }),

                    TextInput::make('ttl')
                        ->label('Tempat/Tgl Lahir')
                        ->belowContent('Contoh: Denpasar/20 Agustus 1995')
                        ->required()
                        ->afterStateHydrated(function ($set, $record) {
                            if (!$record && $this->mahasiswa) {
                                $tempat = $this->mahasiswa->TempatLahir ?? null;
                                $tgl = $this->mahasiswa->TglLahir ?? null;
                                $set('ttl', $tempat . '/' . $tgl ?? null);
                            }
                        }),

                    Select::make('prodi')
                        ->label('Program Studi')
                        ->options([
                            'AKUNTANSI' => 'AKUNTANSI',
                            'MANAJEMEN' => 'MANAJEMEN',
                            'IESP' => 'IESP',
                            'AKUNTANSI PERPAJAKAN' => 'AKUNTANSI PERPAJAKAN',
                        ])
                        ->required()
                        ->afterStateHydrated(function ($set, $record) {
                            if (!$record && $this->mahasiswa) {
                                $set('prodi', strtoupper($this->mahasiswa->Jurusan) ?? null);
                            }
                        }),

                    Select::make('agama')
                        ->label('Agama')
                        ->options([
                            'ISLAM' => 'ISLAM',
                            'HINDU' => 'HINDU',
                            'BUDHA' => 'BUDHA',
                            'KRISTEN KATOLIK' => 'KRISTEN KATOLIK',
                            'KRISTEN PROTESTAN' => 'KRISTEN PROTESTAN',
                            'KONGHUCU' => 'KONGHUCU',
                        ])
                        ->required()
                        ->afterStateHydrated(function ($set, $record) {
                            if (!$record && $this->mahasiswa) {
                                $set('agama', strtoupper($this->mahasiswa->Agama) ?? null);
                            }
                        }),

                    Select::make('jenis_kelamin')
                        ->label('Jenis Kelamin')
                        ->options([
                            'PRIA' => 'PRIA',
                            'WANITA' => 'WANITA',
                        ])
                        ->required()
                        ->afterStateHydrated(function ($set, $record) {
                            if (!$record && $this->mahasiswa) {
                                $set('jenis_kelamin', $this->normalisasiJenisKelamin($this->mahasiswa->JenisKelamin));
                            }
                        }),

                    TextInput::make('asal')
                        ->label('Daerah Asal')
                        ->placeholder('Denpasar')
                        ->required(),

                    TextInput::make('alamat')
                        ->label('Alamat Sekarang')
                        ->required()
                        ->afterStateHydrated(function ($set, $record) {
                            if (!$record && $this->mahasiswa) {
                                $set('alamat', $this->mahasiswa->Alamat ?? null);
                            }
                        }),

                    TextInput::make('nama_orangtua')
                        ->label('Nama Orang Tua / Wali')
                        ->required(),

                    TextInput::make('nomor_hp')
                        ->label('Nomor HP')
                        ->required()
                        ->afterStateHydrated(function ($set, $record) {
                            if (!$record && $this->mahasiswa) {
                                $set('nomor_hp', $this->mahasiswa->NoTelp ?? null);
                            }
                        }),

                    TextInput::make('nomor_wa')
                        ->label('Nomor Whatsapp')
                        ->required()
                        ->afterStateHydrated(function ($set, $record) {
                            if (!$record && $this->mahasiswa) {
                                $set('nomor_wa', $this->mahasiswa->NoTelp ?? null);
                            }
                        }),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->disabled()
                        ->dehydrated(true)
                        ->afterStateHydrated(function ($set, $record) {
                            if (!$record) {
                                $set('email', Auth::user()->email);
                            }
                        }),

                    TextInput::make('ipk')
                        ->label('Indeks Prestasi (IPK)')
                        ->placeholder('3,95')
                        ->belowContent('Contoh: 3,95')
                        ->required(),

                    Select::make('predikat_lulus')
                        ->label('Predikat Kelulusan')
                        ->options([
                            'DENGAN PUJIAN' => 'DENGAN PUJIAN',
                            'SANGAT MEMUASKAN' => 'SANGAT MEMUASKAN',
                            'MEMUASKAN' => 'MEMUASKAN',
                        ])
                        ->required(),
                ])
                ->columns(2),

            Section::make('Informasi Tugas Akhir')
                ->schema([
                    DatePicker::make('tanggal_lulus')
                        ->label('Tanggal Lulus Ujian Skripsi')
                        ->required()
                        ->afterStateHydrated(function ($set, $record) {
                            if (!$record && $this->skripsi) {
                                $set('tanggal_lulus', $this->skripsi->tanggalProposal ?? null);
                            }
                        }),

                    TextInput::make('judul')
                        ->label('Judul Skripsi')
                        ->required()
                        ->afterStateHydrated(function ($set, $record) {
                            if (!$record && $this->skripsi) {
                                $set('judul', $this->skripsi->judul ?? null);
                            }
                        }),

                    TextInput::make('tempat_penelitian')
                        ->label('Tempat Penelitian')
                        ->placeholder('tempat penelitian...')
                        ->required(),

                    TextInput::make('alamat_penelitian')
                        ->label('Alamat Penelitian')
                        ->placeholder('alamat penelitian...')
                        ->required(),

                    TextInput::make('nomor_sk')
                        ->label('Nomor SK Pembimbing (dilihat pada Surat Penugasan)')
                        ->placeholder('476/UW-FE/PD-10/V/2018')
                        ->belowContent('Contoh: 476/UW-FE/PD-10/V/2018')
                        ->required(),

                    DatePicker::make('tgl_sk')
                        ->label('Tanggal SK Pembimbing (dilihat pada Surat Penugasan)')
                        ->placeholder('tanggal sk pembimbing')
                        ->required(),
                ])
                ->columns(2),

            Section::make('Informasi Pekerjaan')
                ->schema([
                    Select::make('bekerja')
                        ->label('Status Bekerja')
                        ->options([
                            'SUDAH' => 'SUDAH',
                            'BELUM' => 'BELUM',
                        ])
                        ->required()
                        ->reactive(),

                    TextInput::make('pekerjaan')
                        ->label('Pekerjaan Wisudawan')
                        ->placeholder('pekerjan wisudawan...')
                        ->visible(fn($get) => $get('bekerja') === 'SUDAH'),

                    TextInput::make('nama_kantor')
                        ->label('Nama Kantor / Perusahaan')
                        ->placeholder('nama kantor/perusahaan...')
                        ->visible(fn($get) => $get('bekerja') === 'SUDAH'),

                    TextInput::make('alamat_kantor')
                        ->label('Alamat Kantor / Perusahaan')
                        ->placeholder('alamat kantor/perusahaan...')
                        ->visible(fn($get) => $get('bekerja') === 'SUDAH'),

                    TextInput::make('telp_kantor')
                        ->label('Telp Kantor / Perusahaan')
                        ->placeholder('telp kantor/perusahaan...')
                        ->visible(fn($get) => $get('bekerja') === 'SUDAH'),

                    TextInput::make('keterampilan')
                        ->label('Tambahan Keterampilan')
                        ->placeholder('tambahan keterampilan...'),
                ])
                ->columns(2),
        ];
    }

    public function getFormUploadFileYudisium(): array
    {
        return [
            FileUpload::make('file_skripsi')
                ->label('File Skripsi (PDF)')
                ->acceptedFileTypes(['application/pdf'])
                ->directory('file_skripsi')
                ->downloadable()
                ->previewable(false),

            FileUpload::make('file_jurnal')
                ->label('File Jurnal (PDF)')
                ->acceptedFileTypes(['application/pdf'])
                ->directory('file_jurnal')
                ->downloadable()
                ->previewable(false),

            FileUpload::make('file_kwitansi')
                ->label('Kwitansi Pembayaran Yudisium')
                ->directory('file_kwitansi')
                ->downloadable()
                ->previewable(false),

            FileUpload::make('file_pppm')
                ->label('Kwitansi PPPM')
                ->directory('file_pppm')
                ->downloadable()
                ->previewable(false),

            FileUpload::make('file_toefle')
                ->label('Kwitansi Toefle dan Transkrip Nilai')
                ->directory('file_toefle')
                ->downloadable()
                ->previewable(false),

            FileUpload::make('foto_slide')
                ->label('Foto Slide')
                ->image()
                ->directory('foto_slide')
                ->downloadable(),

            FileUpload::make('foto_biodata')
                ->label('Foto Biodata')
                ->image()
                ->directory('foto_biodata')
                ->downloadable(),
        ];
    }

    private function normalisasiJenisKelamin(?string $jk): ?string
    {
        if (!$jk) return null;

        $jk = strtolower(trim($jk));

        return match (true) {
            in_array($jk, ['l', 'laki', 'laki-laki', 'pria']) => 'PRIA',
            in_array($jk, ['p', 'perempuan', 'wanita']) => 'WANITA',
            default => null,
        };
    }

    public function showFile(): MediaAction
    {
        return MediaAction::make('showFile')
            ->label('Show file')
            ->modalHeading(function (array $arguments) {
                return 'Show file: ' . $arguments['label'];
            })
            ->icon('heroicon-o-eye')
            ->color('gray')
            ->size('xs')
            ->media(function (array $arguments) {
                $yudisium = $this->yudisium[$arguments['field']] ?? null;
                return url('storage/' . $yudisium);
            });
    }

    public function showContoh(): MediaAction
    {
        return MediaAction::make('showContoh')
            ->label('Contoh')
            ->modalHeading(function (array $arguments) {
                return 'Show file: ' . $arguments['label'];
            })
            ->icon('heroicon-o-eye')
            ->color('warning')
            ->size('xs')
            ->link()
            ->media(function (array $arguments) {
                $yudisium = $arguments['field'] ?? null;
                return asset($yudisium);
            });
    }

    public function uploadFile(): Action
    {
        return Action::make('uploadFile')
            ->label('Upload file')
            ->modalHeading(fn(array $arguments) => 'Upload file: ' . ($arguments['label'] ?? ''))
            ->icon('heroicon-o-cloud-arrow-up')
            ->size('xs')
            ->schema(function (array $arguments) {
                return [
                    FileUpload::make('upload')
                        ->label('File')
                        ->required()
                        ->disk('public')
                        ->directory('uploads')
                        ->acceptedFileTypes(explode(',', $arguments['accept'] ?? 'application/pdf'))
                        ->downloadable(),
                ];
            })
            ->action(function (array $data, array $arguments) {
                $this->yudisium->update([
                    $arguments['field'] => $data['upload']
                ]);
                $this->yudisium->refresh();
                $this->dispatch('refreshUploadTable');
                Notification::make()
                    ->title('File: ' . $arguments['label'] . ' berhasil diupload')
                    ->success()
                    ->send();
            });
    }
}
