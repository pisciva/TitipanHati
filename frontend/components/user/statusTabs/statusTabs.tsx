'use client'

import React from 'react'

interface StatusTabsProps {
  statusAktif: string
  setStatusAktif: React.Dispatch<React.SetStateAction<string>>
  statusList: string[]
}

export default function StatusTabs({
  statusAktif,
  setStatusAktif,
  statusList,
}: StatusTabsProps) {
  return (
    <div className="flex gap-4 mb-8 flex-wrap">
      {statusList.map((status) => (
        <button
          key={status}
          onClick={() => setStatusAktif(status)}
          className={`px-6 py-2 rounded-full border text-sm font-medium transition ${
            statusAktif === status
              ? 'border-[#FF4400] text-[#FF4400] bg-[#FFF2EE]'
              : 'border-gray-300 text-gray-600 hover:border-[#FF4400]'
          }`}
        >
          {status}
        </button>
      ))}
    </div>
  )
}
