"use client";
import { ChevronLeft, ChevronRight } from "lucide-react";

export default function CalendarSection() {
  return (
    <div className="bg-white rounded-xl p-6 shadow-sm border mb-8">
      <div className="flex justify-between items-center mb-4">
        <button className="p-1 border rounded-md">
          <ChevronLeft className="w-4 h-4" />
        </button>
        <h2 className="font-semibold text-lg">October</h2>
        <button className="p-1 border rounded-md">
          <ChevronRight className="w-4 h-4" />
        </button>
      </div>

      <div className="grid grid-cols-7 text-center text-sm font-semibold text-gray-600 mb-2">
        <div>Mon</div>
        <div>Tue</div>
        <div>Wed</div>
        <div>Thu</div>
        <div>Fri</div>
        <div>Sat</div>
        <div>Sun</div>
      </div>

      <div className="grid grid-cols-7 gap-2 text-center">
        {[...Array(31)].map((_, i) => (
          <div
            key={i}
            className={`py-2 rounded-md ${
              i + 1 === 18
                ? "bg-[#FF6B00] text-white font-semibold"
                : "hover:bg-gray-100"
            }`}
          >
            {i + 1}
          </div>
        ))}
      </div>
    </div>
  );
}
