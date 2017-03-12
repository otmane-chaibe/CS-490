class MainDriver {
	public static void main(String[] args) {
		MainDriver main = new MainDriver();
		System.out.println(main.sum(5,2));
		System.out.println(main.sum(1,1));
	}

	public static int sum(int a, int b) {
		return a + b;
	}
}