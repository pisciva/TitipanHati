'use client'

import React, { useState } from 'react'
import SidebarUser from '@/components/user/sidebarUser/sidebarUser'
import StatusTabs from '@/components/user/statusTabs/statusTabs'
import DonasiList from '@/components/user/donationLIst/donationList'

export default function RiwayatDonasiPage() {
  const [statusAktif, setStatusAktif] = useState<string>('Menunggu Penjemputan')

  const dataDonasi = [
    {
      status: 'Aktif',
      judul: 'Donasi Bencana Alam Gempa Bumi – Di Suatu Daerah',
      tanggal: '2 Oktober 2025',
    },
    {
      status: 'Tidak Aktif',
      judul: 'Donasi Panti Asuhan Kasih Ibu',
      tanggal: '10 September 2025',
    },
  ]

  const statusList = [
    'Menunggu Penjemputan',
    'Dalam Perjalanan',
    'Selesai Disalurkan',
    'Dibatalkan',
  ]

  return (
    <div className="flex min-h-screen bg-white">
      <SidebarUser />

      <main className="flex-1 ml-[300px] px-16 py-24">
        <h1 className="text-2xl font-semibold mb-8">Riwayat Donasi</h1>

        <div className="border border-gray-300 rounded-2xl p-8">
          <StatusTabs
            statusAktif={statusAktif}
            setStatusAktif={setStatusAktif}
            statusList={statusList}
          />
          <DonasiList dataDonasi={dataDonasi} />
        </div>
      </main>
    </div>
  )
}
