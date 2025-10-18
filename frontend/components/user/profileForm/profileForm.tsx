'use client'

import { useState } from 'react'

export default function ProfileForm() {
  const [nama, setNama] = useState('')
  const [telepon, setTelepon] = useState('')
  const [email, setEmail] = useState('')
  const [alamat, setAlamat] = useState('')

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault()
    console.log({ nama, telepon, email, alamat })
  }

  return (
    <form onSubmit={handleSubmit} className="space-y-8">
      <div className="border border-gray-300 rounded-xl p-6 space-y-6">
        <div>
          <label className="text-[#FF4400] font-semibold">Nama Lengkap</label>
          <input
            type="text"
            placeholder="Masukkan Nama Depan Kamu"
            value={nama}
            onChange={(e) => setNama(e.target.value)}
            className="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#FF4400]"
          />
        </div>
        <div>
          <label className="text-[#FF4400] font-semibold">Nomor Telepon</label>
          <input
            type="text"
            placeholder="(62) Nomor Telepon Anda"
            value={telepon}
            onChange={(e) => setTelepon(e.target.value)}
            className="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#FF4400]"
          />
        </div>
        <div>
          <label className="text-[#FF4400] font-semibold">Alamat Email</label>
          <input
            type="email"
            placeholder="Masukkan Alamat Email Anda"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
            className="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#FF4400]"
          />
        </div>
      </div>

      <div className="border border-gray-300 rounded-xl p-6 space-y-6">
        <h2 className="text-xl font-semibold">Alamat Default</h2>
        <input
          type="text"
          placeholder="Masukkan Alamat Default Kamu"
          value={alamat}
          onChange={(e) => setAlamat(e.target.value)}
          className="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#FF4400]"
        />
      </div>

      <div className="flex justify-end">
        <button
          type="submit"
          className="bg-[#0054A5] px-8 py-2 text-white font-semibold rounded-full hover:bg-[#003E7A] transition"
        >
          Simpan
        </button>
      </div>
    </form>
  )
}
