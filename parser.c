#include <stdio.h>
#include <string.h>
#include <stdlib.h>

int main ( void )
{

	int arrShip[17][2];//holds all points of straight lines
	int arrCircle[4][4];//holds all middle points and radius sizes of circles
	int state=0; //1 for ship body ; 2 for circles;3 office; 4 window;5 toren;6 mifras
	int lcount=0; //counts the line number of each ship part (body, window, etc.)
	int shipCount=0;//counts the main index of the ship arr to set values
	int circleCount=0;//counts the main index of the circle arr to set values

	char x[5]; //the x value before being convert into integer
	char y[5]; //the y value before being convert into integer

	int isSlash(char *str);//return 1 if char is a '/' and 0 elsewisw
	char* getX(char *str);//return the X value (in char)
	char* getY(char *str);//return the Y value (in char)
	char* getX2(char *str);//return the X2 value (in char) - it's the second point in the txt file
	char* getY2(char *str);//return the Y2 value (in char) - it's the second point in the txt file
	
	/*********************************/
	/*	   debug print arr func		 */
	void printArrShip(int str[17][2]);
	void printArrCircle(int str[4][4]);
	/*********************************/

   static const char filename[] = "data.txt";
   FILE *file = fopen ( filename, "r" );
   if ( file != NULL )
   {
      char line [ 64 ]; /* or other suitable maximum line size */

      while ( fgets ( line, sizeof line, file ) != NULL ) /* read a line */
      {
         //fputs ( line, stdout ); /* write the line */
		  if(isSlash(line))
		  {
			  state++;
			  lcount=1;
			  continue;
		  }
		  
		  switch( state ) 
			{
				case 1:
					strcpy(x,getX(line));
					arrShip[shipCount][0]=atoi(x);
					strcpy(y,getY(line));
					arrShip[shipCount][1]=atoi(y);
					//printf("%s \n",y);
					//printf("%d\n",atoi(x));
					//printf("%d\n",arrShip[shipCount][0]);
					//printf ("The value entered is : %d  %d\n",arrShip[shipCount][0],arrShip[shipCount][1]);
					shipCount++;
					lcount++;
					break;
				case 2 :
					strcpy(x,getX(line));
					arrCircle[circleCount][0]=atoi(x);
					strcpy(y,getY(line));
					arrCircle[circleCount][1]=atoi(y);
					
					//strcpy(x,getX2(line)); - do not delete this comment!
					arrCircle[circleCount][2]=-999;
					strcpy(y,getY2(line));
					arrCircle[circleCount][3]=atoi(y);
					circleCount++;
					lcount++;
					break;
				case 3 :
					strcpy(x,getX(line));
					arrShip[shipCount][0]=atoi(x);
					strcpy(y,getY(line));
					arrShip[shipCount][1]=atoi(y);
					if (lcount==3)
					{
						shipCount++;
						strcpy(x,getX2(line));
						//printf("%s \n",x);
						arrShip[shipCount][0]=atoi(x);
						strcpy(y,getY2(line));
						arrShip[shipCount][1]=atoi(y);
					}
					shipCount++;
					lcount++;
					break;
				case 4 :
					strcpy(x,getX(line));
					arrShip[shipCount][0]=atoi(x);
					strcpy(y,getY(line));
					arrShip[shipCount][1]=atoi(y);
					shipCount++;
					lcount++;
					break;
				case 5 :
					strcpy(x,getX(line));
					arrShip[shipCount][0]=atoi(x);
					strcpy(y,getY(line));
					arrShip[shipCount][1]=atoi(y);
					shipCount++;

					strcpy(x,getX2(line));
					arrShip[shipCount][0]=atoi(x);
					strcpy(y,getY2(line));
					arrShip[shipCount][1]=atoi(y);
					shipCount++;
					lcount++;
					break;
				case 6 :
					strcpy(x,getX(line));
					arrShip[shipCount][0]=atoi(x);
					strcpy(y,getY(line));
					arrShip[shipCount][1]=atoi(y);
					shipCount++;
					lcount++;
					break;
			}

      }
      fclose ( file );
   }
   else
   {
      perror ( filename ); /* why didn't the file open? */
   }
   printArrShip(arrShip);
   printArrCircle(arrCircle);
	system("pause");
   return 0;
}

int isSlash(char *str)
{
	if (str[0]=='/')
		return 1;
	else
		return 0;
}
char* getX(char *str)
{
	int i=1;
	int j=0;
	char answer[5]={'\0'};
	while (str[i]!=',')
	{
		i++;
		answer[j]=str[i-1];
		j++;
	}
	//printf("%s \n",answer);
	return strdup(answer);
}
char* getY(char *str)
{
	int i=1;
	int j=0;
	char answer[5];
	while (str[i]!=',')
		i++;
	while (str[i]!=')')
	{
		i++;
		answer[j]=str[i];
		j++;
	}
	return strdup(answer);
}
char* getX2(char *str)
{
	int i=1;
	int j=0;
	char answer[5]={'\0'};
	while (str[i]!='(')
		i++;
	i++;
	while (str[i]!=',')
	{
		i++;
		answer[j]=str[i-1];
		j++;
	}
	//printf("%s \n",answer);
	return strdup(answer);
}
char* getY2(char *str)
{
	int i=1;
	int j=0;
	char answer[5];
	while (str[i]!='(')
		i++;
	while (str[i]!=',')
		i++;
	while (str[i]!=')')
	{
		i++;
		answer[j]=str[i];
		j++;
	}
	return strdup(answer);
}


void printArrShip(int str[17][2])
{
	int i;
	for (i=0;i<17;i++)
		printf("%d  %d \n",str[i][0],str[i][1]);
	printf("\n");
}
void printArrCircle(int str[4][4])
{
	int i;
	for (i=0;i<4;i++)
		printf("%d  %d  %d  %d \n",str[i][0],str[i][1],str[i][2],str[i][3]);
	printf("\n");
}
