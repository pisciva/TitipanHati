'use client'

import { useForm } from 'react-hook-form'
import { useState, useEffect } from 'react'
import Toast from '@/components/layouts/Toast'
import Link from 'next/link'
import axios from 'axios'

export default function ForgotPass() {
    const { register, handleSubmit } = useForm<{ email: string }>({
        mode: 'onSubmit',
    })

    const [message, setMessage] = useState('')
    const [error, setError] = useState('')
    const [loading, setLoading] = useState(false)
    const [cooldown, setCooldown] = useState(0)

    useEffect(() => {
        const lastSubmit = localStorage.getItem('forgotPassLastSubmit')
        if (lastSubmit) {
            const elapsed = Math.floor((Date.now() - parseInt(lastSubmit)) / 1000)
            const remaining = 30 - elapsed
            if (remaining > 0) setCooldown(remaining)
        }
    }, [])

    useEffect(() => {
        if (cooldown <= 0) return
        const timer = setInterval(() => setCooldown(prev => prev - 1), 1000)
        return () => clearInterval(timer)
    }, [cooldown])

    const onSubmit = async (data: { email: string }) => {
        setError('')
        setMessage('Processing your request...')
        setLoading(true)

        try {

        } catch (err: any) {
            setError(err.response?.data?.message || 'Oops! Something went wrong. Please try again later.')
            setMessage('')
        } finally {
            setLoading(false)
        }
    }

    const onError = (errors: any) => {
        if (errors.email) {
            setError(errors.email.message)
            setMessage('')
        }
    }

    return (
        <div className="min-h-screen flex flex-col items-center justify-center bg-white relative">
            <img src="/Logo.svg" alt="" className='absolute top-30 w-64'/>

            <div className="w-full lg:max-w-150 max-w-120 bg-white lg:bg-white rounded-2xl px-18 py-12 relative border">

                <h1 className="text-2xl lg:text-3xl font-bold text-center mb-2">Lupa Kata Sandi</h1>
                <p className="text-sm lg:text-md font-medium text-[#64748B] text-center mb-12">
                    Jangan khawatir, kami akan membantu Anda mengatur ulang kata sandi!
                </p>

                <form onSubmit={handleSubmit(onSubmit, onError)} className='flex flex-col justify-center items-center w-full'>
                    <div className="relative w-full">
                        <img src="/icon-email.svg"
                            alt="Email Icon"
                            className="absolute left-4 top-1/2 -translate-y-1/2 w-5.5 h-5.5 lg:w-6.2 lg:h-6.2 icon-email"
                        />
                        <input
                            {...register('email', {
                                required: 'Hey, don’t forget input your email <3',
                                pattern: {
                                    value: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
                                    message: 'Hmm… we can’t find your account in our system. Please try again.',
                                },
                            })}
                            placeholder="Email"
                            disabled={loading || cooldown > 0}
                            className="w-full h-12 lg:h-14 pl-14 pr-4 input-base"
                        />
                    </div>

                    <button
                        type="submit"
                        disabled={loading || cooldown > 0}
                        className={`bg-[#FF4400] hover:bg-[#EB3F00] px-12 py-3 rounded-full text-white text-lg font-semibold mt-8 cursor-pointer w-48 flex justify-center items-center
                            ${loading
                                ? 'bg-[#F59E0B] cursor-not-allowed hover:cursor-not-allowed'
                                : cooldown > 0
                                    ? 'bg-[#334155] cursor-not-allowed hover:cursor-not-allowed'
                                    : 'bg-[#0054A5] hover:bg-[#034691] focus:bg-[#EB3F00]'
                            }`}
                    >
                        {loading
                            ? 'Processing...'
                            : cooldown > 0
                                ? `Wait ${cooldown}s`
                                : 'Send Email'}
                    </button>
                </form>

                {message && (
                    <Toast
                        message={message}
                        type={loading ? 'warning' : 'success'}
                        onClose={() => setMessage('')}
                    />
                )}
                {error && <Toast message={error} type="error" onClose={() => setError('')} />}
            </div>

            <Link href={"/login"} className='absolute left-30 bottom-15 flex gap-2 cursor-pointer'>
                <img src="/icon-back.svg" alt="" />
                <p className='text-[#FF4400] font-semibold text-lg'>Kembali</p>
            </Link>
        </div>
    )
}
