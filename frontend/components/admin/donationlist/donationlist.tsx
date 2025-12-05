"use client";
import { ArrowUpRight } from "lucide-react";

interface DonationItemProps {
  status: "Menunggu Penjemputan" | "Dalam Perjalanan" | "Selesai Disalurkan";
  title: string;
  type: string;
  amount: string;
  date: string;
}

const statusColors = {
  "Menunggu Penjemputan": "bg-yellow-100 text-yellow-700",
  "Dalam Perjalanan": "bg-blue-100 text-blue-700",
  "Selesai Disalurkan": "bg-green-100 text-green-700",
};

export default function DonationList() {
  const donations: DonationItemProps[] = [
    {
      status: "Menunggu Penjemputan",
      title: "Donasi Bencana Alam Gempa Bumi – Di suatu daerah",
      type: "Donasi Pakaian",
      amount: "Rp. 1.000.000.000",
      date: "October 2, 2025",
    },
    {
      status: "Dalam Perjalanan",
      title: "Donasi Bencana Alam Gempa Bumi – Di suatu daerah",
      type: "Donasi Pakaian",
      amount: "Rp. -",
      date: "October 2, 2025",
    },
    {
      status: "Selesai Disalurkan",
      title: "Donasi Bencana Alam Gempa Bumi – Di suatu daerah",
      type: "Donasi Pakaian",
      amount: "Rp. 1.000.000.000",
      date: "October 2, 2025",
    },
  ];

  return (
    <div className="bg-white border rounded-2xl p-6 shadow-sm">
      <div className="flex justify-between items-center mb-4">
        <div>
          <h2 className="text-lg font-semibold">Daftar Seluruh Donasi</h2>
          <p className="text-sm text-gray-500">
            Daftar seluruh donasi yang aktif.
          </p>
        </div>
        <button className="text-[#FF6B00] text-sm font-medium">
          Lihat Semua Donasi →
        </button>
      </div>

      <div className="space-y-4">
        {donations.map((donation, i) => (
          <div
            key={i}
            className="border rounded-xl p-4 flex items-center justify-between hover:shadow transition"
          >
            <div className="flex items-center gap-4">
              <span
                className={`text-xs font-medium px-3 py-1 rounded-full ${
                  statusColors[donation.status]
                }`}
              >
                {donation.status}
              </span>
              <div>
                <h3 className="font-semibold text-gray-800">
                  {donation.title}
                </h3>
                <p className="text-sm text-gray-500">{donation.type}</p>
              </div>
            </div>

            <div className="text-right">
              <p className="font-semibold">{donation.amount}</p>
              <p className="text-sm text-gray-500">{donation.date}</p>
            </div>

            <button className="text-[#FF6B00] flex items-center gap-1 ml-4 font-medium text-sm">
              Detail Donasi <ArrowUpRight className="w-4 h-4" />
            </button>
          </div>
        ))}
      </div>
    </div>
  );
}
