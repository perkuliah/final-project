<div>
    <div class="px-4  font-sans text-body">
        <!-- Header --><a href="{{ route('list-user') }}"
                   class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 mb-5">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali ke Daftar User
                </a>
                <br>
        <div class="sm:flex sm:items-center sm:justify-between ">
            <div>
                <!-- Gunakan ukuran dan warna heading sesuai Bootstrap/Soft UI -->
                <h1 class="text-2xl mt-2 font-weight-bold text-gray-900 leading-tight">Edit User</h1>
                <p class="mt-1 text-sm text-body">
                    Perbarui data user
                </p>
            </div>
        </div>

        <!-- Success Message -->
        @if (session()->has('message'))
            <!-- Gunakan border-radius dan padding dari Bootstrap/Soft UI -->
            <div class="rounded-3 bg-green-50 p-4 mb-6 border border-green-100">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <!-- Gunakan warna dan font-weight sesuai Bootstrap/Soft UI -->
                        <p class="text-sm font-weight-medium text-green-800">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <form wire:submit.prevent="update">
            <!-- Tambahkan border-radius konsisten dari Soft UI -->
            <div class="bg-white shadow-sm rounded-3 overflow-hidden">
                <div class="px-6 py-4 border-bottom border-gray-200">
                    <!-- Gunakan font-weight dan warna sesuai Bootstrap/Soft UI -->
                    <h2 class="text-lg font-weight-bold text-gray-900">Informasi Personal</h2>
                </div>

                <div class="px-6 py-4 space-y-6">
                    <!-- Photo Upload -->
                    <div>
                        <label class="block text-sm font-weight-bold text-gray-700 mb-2">Foto Profile</label>
                        <div class="flex items-center space-x-6">
                            <div class="shrink-0">
                                @if ($foto)
                                    <img class="h-20 w-20 object-cover rounded-full border-2 border-gray-200" src="{{ $foto->temporaryUrl() }}" alt="Preview">
                                @elseif ($currentPhoto)
                                    <img class="h-20 w-20 object-cover rounded-full border-2 border-gray-200" src="{{ asset('storage/users/' . $currentPhoto) }}" alt="Current Photo">
                                @else
                                    <div class="h-20 w-20 rounded-full bg-gray-300 flex items-center justify-center border-2 border-gray-200">
                                        <span class="text-gray-500 text-xl">{{ substr($name, 0, 2) }}</span>
                                    </div>
                                @endif
                            </div>
                            <label class="block">
                                <span class="sr-only">Pilih foto</span>
                                <input type="file"
                                       wire:model="foto"
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-2 file:border-0
                                              file:text-sm file:font-weight-semibold
                                              file:bg-gray-100 file:text-gray-700
                                              hover:file:bg-gray-200">
                                @error('foto')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </label>
                            @if ($currentPhoto)
                                <button type="button"
                                        wire:click="removePhoto"
                                        class="inline-flex justify-center py-2 px-4 border border-gray-300 rounded-2 text-sm font-weight-medium text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Hapus Foto
                                </button>
                            @endif
                        </div>
                        @error('foto')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-weight-bold text-gray-700">Nama Lengkap *</label>
                        <!-- Gunakan kelas form-control Bootstrap/Soft UI -->
                        <input type="text"
                               wire:model="name"
                               id="name"
                               class="form-control px-3 py-2 text-sm font-weight-medium text-gray-700 bg-white bg-clip-padding border border-gray-300 rounded-2 transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-pink-500 focus:outline-none focus:shadow-primary-outline">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-weight-bold text-gray-700">Email *</label>
                        <input type="email"
                               wire:model="email"
                               id="email"
                               class="form-control px-3 py-2 text-sm font-weight-medium text-gray-700 bg-white bg-clip-padding border border-gray-300 rounded-2 transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-pink-500 focus:outline-none focus:shadow-primary-outline">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-weight-bold text-gray-700">Username *</label>
                        <input type="text"
                               wire:model="username"
                               id="username"
                               class="form-control px-3 py-2 text-sm font-weight-medium text-gray-700 bg-white bg-clip-padding border border-gray-300 rounded-2 transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-pink-500 focus:outline-none focus:shadow-primary-outline">
                        @error('username')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- WhatsApp -->
                    <div>
                        <label for="whatsapp" class="block text-sm font-weight-bold text-gray-700">Nomor WhatsApp</label>
                        <input type="text"
                               wire:model="whatsapp"
                               id="whatsapp"
                               placeholder="081234567890"
                               class="form-control px-3 py-2 text-sm font-weight-medium text-gray-700 bg-white bg-clip-padding border border-gray-300 rounded-2 transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-pink-500 focus:outline-none focus:shadow-primary-outline">
                        @error('whatsapp')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-weight-bold text-gray-700">Alamat</label>
                        <textarea wire:model="alamat"
                                  id="alamat"
                                  rows="3"
                                  class="form-control px-3 py-2 text-sm font-weight-medium text-gray-700 bg-white bg-clip-padding border border-gray-300 rounded-2 transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-pink-500 focus:outline-none focus:shadow-primary-outline"></textarea>
                        @error('alamat')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-3 mt-6 overflow-hidden">
                <div class="px-6 py-4 border-bottom border-gray-200">
                    <h2 class="text-lg font-weight-bold text-gray-900">Keamanan & Akses</h2>
                </div>

                <div class="px-6 py-4 space-y-6">
                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-weight-bold text-gray-700">Role *</label>
                        <select wire:model="role"
                                id="role"
                                class="form-control px-3 py-2 text-sm font-weight-medium text-gray-700 bg-white bg-clip-padding border border-gray-300 rounded-2 transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-pink-500 focus:outline-none focus:shadow-primary-outline">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Verification -->
                    <div class="flex items-center">
                        <input type="checkbox"
                               wire:model="email_verified"
                               id="email_verified"
                               class="form-check-input h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label for="email_verified" class="ml-2 block text-sm font-weight-medium text-gray-900">
                            Email telah diverifikasi
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-3 mt-6 overflow-hidden">
                <div class="px-6 py-4 border-bottom border-gray-200">
                    <h2 class="text-lg font-weight-bold text-gray-900">Ubah Password</h2>
                    <p class="text-sm text-body mt-1">Kosongkan jika tidak ingin mengubah password</p>
                </div>

                <div class="px-6 py-4 space-y-6">
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-weight-bold text-gray-700">Password Baru</label>
                        <input type="password"
                               wire:model="password"
                               id="password"
                               class="form-control px-3 py-2 text-sm font-weight-medium text-gray-700 bg-white bg-clip-padding border border-gray-300 rounded-2 transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-pink-500 focus:outline-none focus:shadow-primary-outline">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-weight-bold text-gray-700">Konfirmasi Password</label>
                        <input type="password"
                               wire:model="password_confirmation"
                               id="password_confirmation"
                               class="form-control px-3 py-2 text-sm font-weight-medium text-gray-700 bg-white bg-clip-padding border border-gray-300 rounded-2 transition ease-in-out focus:text-gray-700 focus:bg-white focus:border-pink-500 focus:outline-none focus:shadow-primary-outline">
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3 mt-6 rounded-3">
                <a href="{{ route('list-user') }}"
                   class="inline-flex justify-center py-2 px-4 border border-gray-300 rounded-2 text-sm font-weight-medium text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Batal
                </a>
                <button type="submit"
                        wire:loading.attr="disabled"
                        class="ms-4 inline-flex justify-center py-2 px-4 border border-transparent rounded-2 text-sm font-weight-medium text-white bg-gradient-red shadow-soft-md bg-150 bg-x-25 hover:shadow-soft-xxs disabled:opacity-50 transition-all ease-in-out duration-200">
                    <svg wire:loading class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span wire:loading.remove >Simpan Perubahan</span>
                    <span wire:loading >Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Loading Overlay -->
    @if ($foto)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50" wire:loading.class.remove="hidden">
            <div class="bg-white p-6 rounded-3 shadow-xl">
                <div class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-gray-900">Mengupload foto...</span>
                </div>
            </div>
        </div>
    @endif
</div>