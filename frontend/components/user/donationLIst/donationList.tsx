'use client'

import React from 'react'

interface Donasi {
  status: string
  judul: string
  tanggal: string
}

interface DonasiListProps {
  dataDonasi: Donasi[]
}

export default function DonasiList({ dataDonasi }: DonasiListProps) {
  return (
    <div className="space-y-4">
      {dataDonasi.map((donasi, index) => (
        <div
          key={index}
          className="border border-gray-300 rounded-2xl px-6 py-4 hover:shadow-md transition"
        >
          <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            {/* Status + Judul */}
            <div className="flex items-start md:items-center gap-4 flex-1 min-w-0">
              <span
                className={`text-sm font-medium px-3 py-1 rounded-full inline-block ${
                  donasi.status === 'Aktif'
                    ? 'bg-green-100 text-green-700'
                    : 'bg-gray-100 text-gray-500'
                }`}
              >
                {donasi.status}
              </span>
              <div className="min-w-0">
                <p className="font-semibold text-gray-900 truncate">
                  {donasi.judul}
                </p>
              </div>
            </div>

            {/* Tanggal + Tombol Detail */}
            <div className="flex items-center gap-6 mt-2 md:mt-0">
              <p className="text-sm text-gray-500 whitespace-nowrap">
                {donasi.tanggal}
              </p>
              <button className="text-[#FF4400] font-medium hover:underline whitespace-nowrap">
                Detail Donasi ↗
              </button>
            </div>
          </div>
        </div>
      ))}
    </div>
  )
}
