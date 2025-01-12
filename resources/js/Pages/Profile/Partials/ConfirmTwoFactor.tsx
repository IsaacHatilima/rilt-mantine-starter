import { useNotification } from '@/Context/NotificationContext';
import { useForm } from '@inertiajs/react';
import { Button, Modal, PinInput } from '@mantine/core';
import { useDisclosure } from '@mantine/hooks';
import axios from 'axios';
import React from 'react';

function ConfirmTwoFactor({ refreshUser }: { refreshUser: () => void }) {
    const [opened, { open: openModal, close: closeModal }] =
        useDisclosure(false);
    const [loading, { open: openLoading, close: closeLoading }] =
        useDisclosure();
    const { data, setData } = useForm({
        code: '',
    });
    const { triggerNotification } = useNotification();

    const handleConfirmTwoFactor = (e: React.FormEvent) => {
        e.preventDefault();
        openLoading();
        axios
            .post('/user/confirmed-two-factor-authentication', {
                code: data.code,
            })
            .then(() => {
                refreshUser();
                triggerNotification(
                    'Success',
                    '2FA has been confirmed.',
                    'green',
                );
                closeModal();
                closeLoading();
            })
            .catch(() => {
                triggerNotification(
                    'Warning',
                    'Unable to confirm 2FA.',
                    'yellow',
                );
                closeLoading();
            });
    };

    return (
        <div className="mt-2 flex items-center justify-center gap-4">
            <Button
                onClick={openModal}
                type="button"
                variant="filled"
                color="rgba(0, 0, 0, 1)"
            >
                Confirm 2FA
            </Button>
            <Modal opened={opened} onClose={closeModal} title="Authentication">
                <div className="flex items-center justify-center gap-4 px-4">
                    <form onSubmit={handleConfirmTwoFactor}>
                        <PinInput
                            mt="xl"
                            oneTimeCode
                            type="number"
                            length={6}
                            inputMode="numeric"
                            name="code"
                            value={data.code}
                            onChange={(value: string) => setData('code', value)}
                            autoFocus={true}
                        />

                        <div className="my-4 flex items-center gap-4">
                            <Button
                                type="submit"
                                fullWidth
                                variant="filled"
                                color="rgba(0, 0, 0, 1)"
                                loading={loading}
                                loaderProps={{ type: 'dots' }}
                            >
                                Confirm 2FA
                            </Button>
                        </div>
                    </form>
                </div>
            </Modal>
        </div>
    );
}

export default ConfirmTwoFactor;
