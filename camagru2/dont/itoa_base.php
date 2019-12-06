char	*ft_itoa_base(int val, int base)
{
	char	*base_string = "0123456789ABCDEF";
	long	num;
	int	len;
	char	*ret;

	num = val;
	len = 0;
	if (val == 0)
		return ("0");
	while (num)
	{
		len++;
		num /= base;
	}
	num = val;
	if (val < 0)
	{
		if (base == 10)
			len++;
		num *= -1;
	}
	ret = (char *)malloc(sizeof(char) * len);
	ret[len] = '\0';
	while (num)
	{
		printf("%ld\n", num);
		ret[--len] = base_string[num % base];
		num /= base;
	}
	if (val < 0 && base == 10)
	ret[0] = '-';
	return (ret);
}
